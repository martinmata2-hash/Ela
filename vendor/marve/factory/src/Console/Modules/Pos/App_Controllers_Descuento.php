<?php
namespace App\Controllers;
use Marve\Ela\Controllers\ModelController;
//#TODO Verifica la clase
use App\Models\Pos\Descuentos;
use Marve\Ela\Core\CurrentUser;

class Descuento extends ModelController
{
    /**
     */
    public function __construct() 
    {                
      $this->class = new Descuentos(CurrentUser::getDb());
      parent::__construct("DesID");        
    }           
}
