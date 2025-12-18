<?php
namespace App\Models\Catalogos;

use App\Models\Data\CategoriasD;
use Marve\Ela\Core\Model;
use Marve\Ela\Core\DotEnv;

class Categorias extends Model
{
   
         
    /**
     *
     * @var CategoriasD
     */
    public $data;

    public function __construct( $data_base = "")
    {
        if($data_base == "")
            $data_base = DotEnv::getDB();           
        $this->data_base = $data_base;
        $this->message = array();        
        parent::__construct($data_base, "categorias");
        
        //Inicar tabla
        $this->createTable(new CategoriasD());
        $this->updateTable();
        //TODO define the rules for adding and editing
        $this->addRules = 
        [
            "CatNombre"=>"required|unique:CatNombre",
            
        ];
        $this->editRules = 
        [
            "CatNombre"=>"required|",            
        ];
    }    
    
                  
    
}

