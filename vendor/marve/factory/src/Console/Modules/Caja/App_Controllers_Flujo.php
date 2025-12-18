<?php
namespace App\Controllers;
use Marve\Ela\Controllers\ModelController;
//#TODO Verifica la clase
use App\Models\Reportes\Flujos;
use Marve\Ela\Core\CurrentUser;

class Flujo extends ModelController
{
    /**
     */
    public function __construct() 
    {                
      $this->class = new Flujos(CurrentUser::getDb());
      parent::__construct("FluID");        
    }           
}
