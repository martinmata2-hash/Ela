<?php
namespace App\Controllers;
use Marve\Ela\Controllers\ModelController;
//#TODO Verifica la clase
use App\Models\Catalogos\Ajustes;
use Marve\Ela\Core\CurrentUser;

class Ajuste extends ModelController
{
    /**
     */
    public function __construct() 
    {                
      $this->class = new Ajustes(CurrentUser::getDb());
      parent::__construct("AjuNombre");        
    }           

     protected function getAll()
    {   
		  $this->request =$this->class->get(0,0,0);
	    $this->message = $this->class->message;
	    return $this->request;	
    }
}
