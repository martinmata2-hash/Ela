<?php
namespace App\Controllers;
use Marve\Ela\Controllers\ModelController;
//#TODO Verifica la clase
use App\Models\Catalogos\Categorias;
use Marve\Ela\Core\CurrentUser;

class Categoria extends ModelController
{
    /**
     */
    public function __construct() 
    {                
      $this->class = new Categorias(CurrentUser::getDb());
      parent::__construct("CatID");        
    }           
}
