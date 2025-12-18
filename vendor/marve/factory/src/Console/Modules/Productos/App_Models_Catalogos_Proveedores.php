<?php
namespace App\Models\Catalogos;

use App\Models\Data\ProveedoresD;
use Marve\Ela\Core\Model;
use Marve\Ela\Core\DotEnv;

class Proveedores extends Model
{
   
         
    /**
     *
     * @var ProveedoresD
     */
    public $data;

    public function __construct( $data_base = "")
    {
        if($data_base == "")
            $data_base = DotEnv::getDB();           
        $this->data_base = $data_base;
        $this->message = array();        
        parent::__construct($data_base, "proveedores");
        
        //Inicar tabla
        $this->createTable(new ProveedoresD());
        $this->updateTable();
        //TODO define the rules for adding and editing
        $this->addRules = 
        [
            "ProvRazon"=>"required|unique:ProvRazon",
            "ProvTelefono"=>"required|min:10"
        ];
        $this->editRules = 
        [
           "ProvRazon"=>"required|",
            "ProvTelefono"=>"required|min:10",          
        ];
    }    
    
                  
    
}

