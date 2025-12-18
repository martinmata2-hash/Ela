<?php
namespace App\Controllers;

use App\ListItems\Ventas as ListItemsVentas;
use App\Models\Catalogos\Clientes;
use App\Models\Catalogos\Productos;
use App\Models\Data\ProductosD;
use Marve\Ela\Controllers\ModelController;
//#TODO Verifica la clase
use App\Models\Pos\Presupuestos;
use Marve\Ela\Core\CurrentUser;
use stdClass;

class Presupuesto extends ModelController
{
    /**
     */
    public function __construct() 
    {                
      $this->class = new Presupuestos(CurrentUser::getDb());
      parent::__construct("FacID");        
    }           

      protected function codigo($data)
    {      
        $descuento = (new Clientes(CurrentUser::getDb()))->get($data->cliente, "CliID")->CliDescuento??0.00;
        $producto = new ProductosD ((new Productos(CurrentUser::getDb()))->get($data->codigo,"ProCodigo"));        
        $this->request = ListItemsVentas::getItem($producto, $data->cantidad, $data->precio, $descuento);
        return $this->request;
    }
}
