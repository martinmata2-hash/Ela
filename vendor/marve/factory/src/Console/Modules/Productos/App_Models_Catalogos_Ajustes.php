<?php
namespace App\Models\Catalogos;

use App\Models\Data\AjustesD;
use Marve\Ela\Core\Model;
use Marve\Ela\Core\DotEnv;

class Ajustes extends Model
{
   
         
    /**
     *
     * @var AjustesD
     */
    public $data;

    public function __construct( $data_base = "")
    {
        if($data_base == "")
            $data_base = DotEnv::getDB();           
        $this->data_base = $data_base;
        $this->message = array();        
        parent::__construct($data_base, "ajustes");
        
        //Inicar tabla
        $this->createTable(new AjustesD());
        $this->updateTable();
        //TODO define the rules for adding and editing
        $this->addRules = 
        [
            //"AjuNombre"=>"required|min:1|unique:AjuNombre",
            //"AjuValor"=>"required|min:0",            
        ];
        $this->editRules = 
        [
            //"AjuNombre"=>"required|",
            //"AjuValor"=>"required|min:0",            
        ];
    }    
    
                  
    
}

