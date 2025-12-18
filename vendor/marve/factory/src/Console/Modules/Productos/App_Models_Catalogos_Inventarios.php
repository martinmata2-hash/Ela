<?php
namespace App\Models\Catalogos;

use App\Models\Data\InventariosD;
use App\Models\Data\ProductosD;
use Marve\Ela\Core\Model;
use Marve\Ela\Core\DotEnv;
use stdClass;

class Inventarios extends Model
{
   
         
    /**
     *
     * @var InventariosD
     */
    public $data;

    public function __construct( $data_base = "")
    {
        if($data_base == "")
            $data_base = DotEnv::getDB();           
        $this->data_base = $data_base;
        $this->message = array();        
        parent::__construct($data_base, "inventarios");
        
        //Inicar tabla
        $this->createTable(new InventariosD());
        $this->updateTable();
        //TODO define the rules for adding and editing
        $this->addRules = 
        [
            "InvProducto"=>"required|unique:InvProducto"
        ];
        $this->editRules = 
        [
            "InvProducto"=>"required|"            
        ];
    }    
    
    public function input($id, $cantidad)
    {
        $inventario = $this->get($id,"InvProducto");
        if($inventario !== 0)
        {
            unset($inventario->InvID);
            $inventario->InvCantidad += $cantidad;
            return $this->edit($inventario,$id, "InvProducto");
        }
        else
        {
            $inventario = new stdClass();
            $inventario->InvProducto = $id;
            $inventario->InvCantidad = $cantidad;
            return parent::store($inventario);
        }
        
    }

    public function output($id, $cantidad)
    {
        $inventario = $this->get($id,"InvProducto");
        if($inventario !== 0)
        {
            if($inventario->InvCantidad >= $cantidad)            
                $this->message[] = "No hay suficiente inventario";
            unset($inventario->InvID);
            $inventario->InvCantidad -= $cantidad;
            return $this->edit($inventario,$id, "InvProducto");
            
        }
        else
        {
            $inventario = new stdClass();
            $inventario->InvProducto = $id;
            $inventario->InvCantidad = -$cantidad;
            return parent::store($inventario);
        }
        
    }
    

    
}

