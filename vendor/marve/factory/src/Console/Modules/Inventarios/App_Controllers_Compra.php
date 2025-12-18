<?php
namespace App\Controllers;

use App\ListItems\Compras as ListItemsCompras;
use Marve\Ela\Controllers\ModelController;
//#TODO Verifica la clase
use App\Models\Inventarios\Compras;
use Marve\Ela\Core\CurrentUser;

class Compra extends ModelController
{
    /**
     */
    public function __construct() 
    {                
      $this->class = new Compras(CurrentUser::getDb());
      parent::__construct("FacID");        
    }           

    protected function codigo($data)
    {      
        $this->request = ListItemsCompras::getItem($data->codigo, $data->cantidad);
        return $this->request;
    }
}
