<?php
namespace App\Models\Caja;

use App\Enum\Movimiento;
use App\Models\Data\CajasD;
use App\Models\Reportes\Flujos;
use Marve\Ela\Core\CurrentUser;
use Marve\Ela\Core\DateCalendar;
use Marve\Ela\Core\Model;
use Marve\Ela\Core\DotEnv;
use stdClass;

class Cajas extends Model
{
   
         
    /**
     *
     * @var CajasD
     */
    public $data;

    public function __construct( $data_base = "")
    {
        if($data_base == "")
            $data_base = DotEnv::getDB();           
        $this->data_base = $data_base;
        $this->message = array();        
        parent::__construct($data_base, "cajas");
        
        //Inicar tabla
        $this->createTable(new CajasD());
        $this->updateTable();
        //TODO define the rules for adding and editing
        $this->addRules = 
        [
            //"AjuNombre"=>"required|unique:AjuNombre",
            //"AjuValor"=>"required|min:0",            
        ];
        $this->editRules = 
        [
            //"AjuNombre"=>"required|",
            //"AjuValor"=>"required|min:0",            
        ];
    }    
    
    public function store(stdClass $data)
    {
        $data->CajUsuario = CurrentUser::getId();
        $data->CajFecha = DateCalendar::now();
        $this->conection->begin_transaction();      
        $id = parent::store($data); 
        if($id > 0)
        {
             if((new Flujos($this->data_base))
                        ->movimiento($data, $id, 
                    ($data->CajTipo == 0)?Movimiento::Entrada:Movimiento::Salida, 
                    ($data->CajTipo == 0)?$data->CajCantidad:(-$data->CajCantidad)) == 0)
                {
                    $this->conection->rollback();
                    return 0;
                }
            $this->conection->commit();
            return $id;
        }
        else            
        {
            $this->conection->rollback();      
            return 0;        
        }
    }
                  
    
}

