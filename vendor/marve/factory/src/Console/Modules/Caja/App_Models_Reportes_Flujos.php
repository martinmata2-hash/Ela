<?php
namespace App\Models\Reportes;

use App\Controllers\Corte;
use App\Enum\Movimiento;
use App\Models\Caja\Cortes;
use App\Models\Data\FlujosD;
use Marve\Ela\Core\CurrentUser;
use Marve\Ela\Core\Model;
use Marve\Ela\Core\DotEnv;


class Flujos extends Model
{
   
         
    /**
     *
     * @var FlujosD
     */
    public $data;

    public function __construct( $data_base = "")
    {
        if($data_base == "")
            $data_base = DotEnv::getDB();           
        $this->data_base = $data_base;
        $this->message = array();        
        parent::__construct($data_base, "flujomonetario");
        
        //Inicar tabla
        $this->createTable(new FlujosD());
        $this->updateTable();
        //TODO define the rules for adding and editing
        $this->addRules = 
        [
            "FluRelacion"=>"required",
            "FluUsuario"=>"required|min:1",
        ];
        $this->editRules = 
        [
            "FluRelacion"=>"required",
            "FluUsuario"=>"required|min:1"          
        ];
    }    
    
    public function movimiento($data, $relacion, Movimiento $tipo, $cantidad)
    {
        $this->data = new FlujosD();
        $this->data->FluRelacion = $relacion;
        $this->data->FluFecha = date("Y-m-d H:i:s");
        $this->data->FluUsuario = CurrentUser::getId();
        $this->data->FluCodigo = $tipo->value;
        $this->data->FluDescripcion = $tipo->toString();
        $this->data->FluMetodo = $data->FacFormaPago??"01";
        $this->data->FluCantidad = $cantidad;
        return parent::store($this->data);
    }

    public function totalMovimiento($usuario,Movimiento $codigo)
    {
        $CORTE = new Cortes($this->data_base);
        $ultimocorte = $CORTE->ultimoCorte($usuario);
        $totales = $this->query("SUM(FluCantidad) as total",$this->table,
        "FluUsuario = $usuario AND FluCodigo = $codigo->value AND FLuFecha >= '$ultimocorte'");   
        return $totales[0]->total??0.00;     
    }       

    public function flujoMovimiento(Movimiento $codigo, $where)
    {
        $totales = $this->query("SUM(FluCantidad) as total",$this->table,
        "FluCodigo = $codigo->value AND $where");   
        return $totales[0]->total??0.00;     
    }

    public function flujoTotalUsuarios($where)
    {
         $resultado = $this->query("date(FluFecha) as fecha, SUM(FluCantidad) as Total, FluCodigo, FluUsuario",
        $this->table, $where,"FluUsuario, FluFecha","FluUsuario, FluCodigo, date(FluFecha)");
        return $resultado;
    }
    public function flujoTotal($where)
    {
        $totales = $this->query("SUM(FluCantidad) as total",$this->table,
        $where);   
        return $totales[0]->total??0.00;     
    }
    public function total($usuario)
    {
        $CORTE = new Cortes($this->data_base);
        $ultimocorte = $CORTE->ultimoCorte($usuario);
        $totales = $this->query("SUM(FluCantidad) as total",$this->table,"FluUsuario = $usuario
         AND FLuFecha >= '$ultimocorte'");   
        return $totales[0]->total??0.00;     
    }
    
}

