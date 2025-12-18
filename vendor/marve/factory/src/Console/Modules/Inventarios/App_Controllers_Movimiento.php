<?php
namespace App\Controllers;

use App\ListItems\Compras;
use Marve\Ela\Controllers\ModelController;
//#TODO Verifica la clase
use App\Models\Inventarios\Movimientos;
use Marve\Ela\Core\CurrentUser;

class Movimiento extends ModelController
{
    /**
     */
    public function __construct() 
    {                
      $this->class = new Movimientos(CurrentUser::getDb());
      parent::__construct("FacID");        
    }           

    protected function codigo($data)
    {      
        $this->request = Compras::getItem($data->codigo, $data->cantidad);
        return $this->request;
    }
}
