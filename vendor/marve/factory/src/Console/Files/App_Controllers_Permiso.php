<?php
namespace App\Controllers;
use Marve\Ela\Core\Controller;
//#TODO Verifica la clase
use App\Core\Access;
use Marve\Ela\Controllers\ModelController;

class Permiso extends ModelController
{    	
    /**
     */
    public function __construct() 
    {                
        $this->class = new Access();
        $this->key = "PusUsuario";
    }       
    
    protected function store($data)
	{		
        $data->PusPermisos = implode(',',array_unique(explode(",",$data->PusPermisos)));  
        return parent::store($data);
	}
        
    protected function get($data)
	{	  		                    
        $this->request = $this->class->get($data->usuario, "PusUsuario");        
        return $this->request;		
	}

}
