<?php
namespace App\Models\<namespace>;

use App\Models\Data\<classD>;
use Marve\Ela\Core\Model;
use Marve\Ela\Core\DotEnv;

class <class> extends Model
{
   
         
    /**
     *
     * @var <classD>
     */
    public $data;

    public function __construct( $data_base = "")
    {
        if($data_base == "")
            $data_base = DotEnv::getDB();           
        $this->data_base = $data_base;
        $this->message = array();        
        parent::__construct($data_base, "<table>");
                
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

