<?php
namespace App\Controllers;
use Marve\Ela\Controllers\ModelController;
//#TODO Verifica la clase
use App\Models\Caja\Cajas;
use Marve\Ela\Core\CurrentUser;

class Caja extends ModelController
{
    /**
     */
    public function __construct() 
    {                
      $this->class = new Cajas(CurrentUser::getDb());
      parent::__construct("CajID");        
    }           
}
