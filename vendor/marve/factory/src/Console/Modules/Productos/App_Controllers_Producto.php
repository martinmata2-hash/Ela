<?php
namespace App\Controllers;
use Marve\Ela\Controllers\ModelController;
//#TODO Verifica la clase
use App\Models\Catalogos\Productos;
use Marve\Ela\Core\CurrentUser;

class Producto extends ModelController
{
    /**
     */
    public function __construct() 
    {                
      $this->class = new Productos(CurrentUser::getDb());
      parent::__construct("ProID");        
    }        
    
    protected function subcat($data)
    {
      $this->request =  $this->class->subcat($data->condicion);
      return $this->request;
    }

}
