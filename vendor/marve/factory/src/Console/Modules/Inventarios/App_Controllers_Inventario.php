<?php
namespace App\Controllers;

use App\ListItems\Inventarios as ListItemsInventarios;
use App\Models\Catalogos\Productos;
use Marve\Ela\Controllers\ModelController;
//#TODO Verifica la clase
use App\Models\Catalogos\Inventarios;
use Marve\Ela\Core\CurrentUser;
use Marve\Ela\Core\Generic;
use stdClass;

class Inventario extends ModelController
{
    /**
     */
    public function __construct() 
    {                
      $this->class = new Inventarios(CurrentUser::getDb());
      parent::__construct("InvID");        
    }         
    
    protected function codigo($data)
    {
      $producto = (new Productos(CurrentUser::getDb()))->get($data->codigo, "ProCodigo");
      $this->request = ListItemsInventarios::getItem($producto,$data->cantidad);
      return $this->request;
    }

    protected function perdida($data)
    {
        $PERDIDA = new Generic(CurrentUser::getDb(),"perdidas");     
        foreach($data as $datos)
        {          
          if($PERDIDA->store($datos) > 0)
          {
            $inventario = new stdClass();
            $inventario->InvCantidad = $datos->PerCantidad;
            $inventario->InvProducto = $datos->PerProducto;
            $id = $this->class->edit($inventario,$datos->PerProducto,"InvProducto");            
          }
          else
          {
            $this->request = 0;
            $this->class->message = "El ajuste de inventario no se archivo";
          }
        }
        
      
      return $this->request;
    }
}
