<?php
namespace App\Models\Pos;

use App\Enum\Movimiento;
use App\Models\Catalogos\Clientes;
use App\Models\Data\PagosD;
use App\Models\Reportes\Flujos;
use Marve\Ela\Core\CurrentUser;
use Marve\Ela\Core\DateCalendar;
use Marve\Ela\Core\Model;
use Marve\Ela\Core\DotEnv;
use Marve\Ela\Html\Table\Table;
use Marve\Ela\Html\Table\Tr;
use stdClass;

class Pagos extends Model
{
   
         
    /**
     *
     * @var PagosD
     */
    public $data;

    public function __construct( $data_base = "")
    {
        if($data_base == "")
            $data_base = DotEnv::getDB();           
        $this->data_base = $data_base;
        $this->message = array();        
        parent::__construct($data_base, "pagos");
        
        //Inicar tabla
        $this->createTable(new PagosD());
        $this->updateTable();
        //TODO define the rules for adding and editing
        $this->addRules = 
        [
            "PagVenta"=>"required|min:1",
            "PagCantidad"=>"required|min:1"            
        ];
        $this->editRules = 
        [
            "PagVenta"=>"required|min:1",
            "PagCantidad"=>"required|min:1"            
        ];
    }    
    
    public function store(stdClass $data)
    {
        $VENTA = new Ventas($this->data_base);
        $venta = $VENTA->get($data->PagVenta,"FacID");        
        $id = parent::store($data);         
        if($id !== 0)
        {
            $ventaTemp = new stdClass();
            $ventaTemp->FacRecibio = $venta->FacRecibio + $data->PagCantidad;
            $ventaTemp->FacTotal = $venta->FacTotal;
            $ventaTemp->FacReceptor = $venta->FacReceptor;
            $VENTA->updateDirect($ventaTemp,$venta->FacID, "FacID");            
            ((new Flujos($this->data_base))->movimiento($data,$id,Movimiento::Pago,$data->PagCantidad));            
            return $id;
        }
        return 0;
    }
    public function adeudos($arguments = [])
    {
         $resultado = $this->query("CliID, CliRazon, SUM(FacTotal - FacRecibio) as adeudo", "ventas inner join clientes on CliID = FacReceptor","FacTotal > FacRecibio",
        0,"FacReceptor",$arguments["limite1"].",".$arguments["limite2"]);
        $html = "";
        foreach ($resultado as $key => $value) 
        {
            $TR = new Tr();
            $TR->tr($value->CliID,"pagodetalle")->td($value->CliRazon)->td($value->adeudo);            
            $html .= $TR->renderSimple();    # code...
        }
        return $html;
    }

    public function aCliente($data)
    {
        $pagos = [];
        $cliente = $data->cliente;
        $CLIENTES = new Clientes($this->data_base);
        unset($data->cliente);
        $parcial = $restante = $data->PagCantidad;
        $ventas = $this->query("FacID, (FacTotal - (FacRecibio + FacRecibio2 + FacRecibio3)) as Adeudo",
        "ventas","FacReceptor = $cliente AND FacTotal > (FacRecibio + FacRecibio2 + FacRecibio3)","FacID asc");
        if($ventas !== 0 && count($ventas)> 0)
        {
             $this->conection->begin_transaction();               
            foreach($ventas as $value)
            {
                if($restante > 0)
                {
                    $pago = new stdClass();
                    $pago->PagVenta = $value->FacID;
                    if($value->Adeudo >= $restante)
                    {
                        $pago->PagCantidad = $restante;
                        $restante = 0;
                    }
                    else
                    {
                        $pago->PagCantidad = $value->Adeudo;
                        $restante -= $value->Adeudo;
                    }
                    $pago->PagParcial = $parcial;
                    $pago->PagFecha = DateCalendar::now();
                    $pago->PagUsuario = CurrentUser::getId();
                    $pago->PagNota = " $data->PagNota | Pago a Cliente ".$CLIENTES->get($cliente, "CliID")->CliNombre;        
                    $pago->PagFormaPago = $data->PagFormaPago;        
                    print_r($pago,true);            
                    $id = $this->store($pago); 
                    if($id == 0)
                    {
                        $this->conection->rollback();
                        return 0;
                    }            

                }
            }
            $this->conection->commit();
            $pagos = ["cliente"=> $cliente, "cantidad" => $parcial];
            return $pagos;
        }
    }
    public function cliente($id)
    {
            $VENTAS = new Ventas();
			$ventas = $VENTAS->get(0,"","FacReceptor = $id AND FacTotal >  (FacRecibio + FacRecibio2 + FacRecibio3)");
			$TABLE = new Table();
            $TABLE->inicio("","","Historial")
            ->header()->htr()->th("30%","Fecha")->th("30%","Total")->th("30%","Adeudo")
            ->body();                        
			$totaladeudo = 0;
			if($ventas !== 0 && count($ventas) > 0)
			{				
				foreach ($ventas as $key => $value) 
				{
					if($value->FacReceptor != 1)
					{
						$tienda = 1;
						$adeudo = $value->FacTotal - ($value->FacRecibio + $value->FacRecibio2 + $value->FacRecibio3);
						$TABLE->tr("_$id","clientedetalle")->td($value->FacFecha)->td($value->FacTotal)->td($adeudo);							
						$totaladeudo += $adeudo;
					}
				}
			}
			$TABLE->tr()->td()->td("Adeudo Total")->td("$ $totaladeudo");				
			return $TABLE->render();
    }
    
}

