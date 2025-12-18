<?php
namespace App\Controllers;
use Marve\Ela\Controllers\ModelController;
//#TODO Verifica la clase
use App\Models\Catalogos\Proveedores;
use Marve\Ela\Core\CurrentUser;

class Proveedor extends ModelController
{
    /**
     */
    public function __construct() 
    {                
      $this->class = new Proveedores(CurrentUser::getDb());
      parent::__construct("ProvID");        
    }           
}
