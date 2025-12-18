<?php
namespace App\Models\Caja;

use App\Models\Data\CorteD;
use App\Models\Reportes\Flujos;
use Marve\Ela\Core\DateCalendar;
use Marve\Ela\Core\Model;
use Marve\Ela\Core\DotEnv;
use stdClass;

class Cortes extends Model
{
   
         
    /**
     *
     * @var CorteD
     */
    public $data;

    public function __construct( $data_base = "")
    {
        if($data_base == "")
            $data_base = DotEnv::getDB();           
        $this->data_base = $data_base;
        $this->message = array();        
        parent::__construct($data_base, "cortes");
        
        //Inicar tabla
        $this->createTable(new CorteD());
        $this->updateTable();
        //TODO define the rules for adding and editing
        $this->addRules = 
        [
            "CorUsuario"=>"required|min:1",
            "CorInicio"=>"required",
            "CorFin"=>"required"            
        ];
        $this->editRules = 
        [
            "CorUsuario"=>"required|min:1",
            "CorInicio"=>"required",
            "CorFin"=>"required"                       
        ];
    }    
    
    public function ultimoCorte(int $usuario)
    {
        $ultimo = $this->lastRecord($this->table,"CorFin", "CorUsuario = $usuario");
        if(count($ultimo) > 0 && $ultimo[0]->ultimo !== null)
            return $ultimo[0]->ultimo;
        else return "0000-00-00 00:00:00";
    }
    
    public function corte($usuario)
    {
        $MOVIMIENTOS = new Flujos($this->data_base);
        $data = new stdClass();
        $data->CorUsuario = $usuario;
        $data->CorInicio = $this->ultimoCorte($usuario);
        $data->CorFin = DateCalendar::now();
        $data->CorEntradas = $MOVIMIENTOS->total($usuario);
        return parent::store($data);
    }
}

