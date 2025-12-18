<?php
namespace App\Models;

use App\Models\Data\ZincD;
use Marve\Ela\Core\Model;
use Marve\Ela\Core\DotEnv;

class Zinc extends Model
{
   
         
    /**
     *
     * @var ZincD
     */
    public $data;

    public function __construct( $data_base = "")
    {
        if($data_base == "")
            $data_base = DotEnv::getDB();           
        $this->data_base = $data_base;
        $this->message = array();        
        parent::__construct($data_base, "zinc");
        
        //Inicar tabla
        $this->createTable(new ZincD());
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
    
                  
    
}

