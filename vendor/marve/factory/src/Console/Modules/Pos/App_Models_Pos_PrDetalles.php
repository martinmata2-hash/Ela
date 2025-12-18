<?php
namespace App\Models\Pos;

use App\Models\Catalogos\Inventarios;
use App\Models\Data\PrDetallesD;
use Marve\Ela\Core\CurrentUser;
use Marve\Ela\Core\Model;
use Marve\Ela\Core\DotEnv;
use stdClass;

class PrDetalles extends Model
{
   
         
    /**
     *
     * @var PrDetallesD
     */
    public $data;

    public function __construct( $data_base = "")
    {
        if($data_base == "")
            $data_base = DotEnv::getDB();           
        $this->data_base = $data_base;
        $this->message = array();        
        parent::__construct($data_base, "presupuestodetalles");
        
        //Inicar tabla
        $this->createTable(new PrDetallesD());
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
        if(CurrentUser::isUser())
        {
            $this->data = new PrDetallesD($data);
            if($this->isValid() === true)
            {               
                 return parent::store($data);                 
            }
            else return 0;
        }
        else return 0;
    }                      
}

