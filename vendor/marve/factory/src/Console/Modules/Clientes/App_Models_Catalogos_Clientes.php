<?php
namespace App\Models\Catalogos;

use App\Models\Data\ClientesD;
use Marve\Ela\Core\Model;
use Marve\Ela\Core\DotEnv;
use Marve\Ela\Html\Table\Table;

class Clientes extends Model
{
   
         
    /**
     *
     * @var ClientesD
     */
    public $data;

    public function __construct( $data_base = "")
    {
        if($data_base == "")
            $data_base = DotEnv::getDB();           
        $this->data_base = $data_base;
        $this->message = array();        
        parent::__construct($data_base, "clientes");
        
        //Inicar tabla
        $this->createTable(new ClientesD());
        $this->updateTable();
        //TODO define the rules for adding and editing
        $this->addRules = 
        [
            "CliNombre"=>"required|unique:CliNombre",
            "CliTelefono"=>"required|min:10",            
        ];
        $this->editRules = 
        [
            "CliNombre"=>"required",
            "CliTelefono"=>"required|min:10",                    
        ];
    }    
    
     public function pagos($cliente)
    {
        $respuesta = $this->query("PagCantidad, PagFecha","pagos p inner join ventas on FacID = PagVenta","FacReceptor = $cliente AND FacTotal > FacRecibio","PagID desc");
        $TABLA = new Table();
        $TABLA->inicio("pagosTable","pagosTable","Historial de Pagos");
        $TABLA->header()->htr()->th("45%","Fecha")->th("45%","Pago")
        ->body();
        if($respuesta !== 0 && count($respuesta))
        {
            foreach($respuesta as $value)
            {
                $TABLA->tr()->td($value->PagFecha)->td($value->PagCantidad);
            }
        }
        return $TABLA->render();
    }
                  
    
}

