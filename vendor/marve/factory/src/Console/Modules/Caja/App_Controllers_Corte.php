<?php
namespace App\Controllers;
use Marve\Ela\Controllers\ModelController;
//#TODO Verifica la clase
use App\Models\Caja\Cortes;
use Marve\Ela\Core\CurrentUser;

class Corte extends ModelController
{
    /**
     */
    public function __construct() 
    {                
      $this->class = new Cortes(CurrentUser::getDb());
      parent::__construct("CorID");        
    }           
}
