<?php
namespace App\Models\Pos;

use App\Models\Data\descuentosD;
use App\Models\Data\ProductosD;
use Marve\Ela\Core\Model;
use Marve\Ela\Core\DotEnv;

class Descuentos extends Model
{
   
         
    /**
     *
     * @var descuentosD
     */
    public $data;

    public function __construct( $data_base = "")
    {
        if($data_base == "")
            $data_base = DotEnv::getDB();           
        $this->data_base = $data_base;
        $this->message = array();        
        parent::__construct($data_base, "descuentos");
        
        //Inicar tabla
        $this->createTable(new descuentosD());
        $this->updateTable();
        //TODO define the rules for adding and editing
        $this->addRules = 
        [
            "DesPorcentaje"=>"required|min:0",
            "DesUsuario"=>"required|min:1",            
        ];
        $this->editRules = 
        [
             "DesPorcentaje"=>"required|min:0",
            "DesUsuario"=>"required|min:1",               
        ];
    }    


     public function descuento(ProductosD $producto)
    {
        $descuento = array();
        $resultado = $this->query("*", $this->table," date(now()) BETWEEN DesInicia AND DesTermina" );
        if(count($resultado) > 0)
        {
            foreach ($resultado as $value) 
            {
                if($value->DesTipo == 0)
                    $descuento["Tipo"] = "Descuento";
                else $descuento["Tipo"] = "Promosion";
                $descuento["Nombre"] = $value->DesNombre;
                if($value->DesObjetivo == "Producto")
                {
                    $productos = explode(',',$value->DesProductos);
                    if(in_array($producto->ProID,$productos))
                    {
                        if($value->DesTipo == 0)
                            $descuento["porcentaje"] = $value->DesPorcentaje;                        
                        else 
                        {
                            $descuento["condicion"] = $value->DesCondicion;
                            $descuento["precio"] = $value->DesPrecio;
                        }
                        return $descuento;
                    }
                    
                }
                elseif($value->DesObjetivo == "Categoria")
                {
                    $categorias = explode(',', $value->DesCategorias);
                    if(in_array($producto->ProCategoria,$categorias))
                    {
                        if($value->DesTipo == 0)
                            $descuento["porcentaje"] = $value->DesPorcentaje;                        
                        else 
                        {
                            $descuento["condicion"] = $value->DesCondicion;
                            $descuento["precio"] = $value->DesPrecio;
                        }
                        return $descuento;
                    }   
                }
                elseif($value->DesObjetivo == "SubCat") 
                {               
                    $subcat = explode(',',$value->DesSubCat);
                    if(in_array($producto->ProSubCat,$subcat))
                    {
                        if($value->DesTipo == 0)
                            $descuento["porcentaje"] = $value->DesPorcentaje;                        
                        else 
                        {
                            $descuento["condicion"] = $value->DesCondicion;
                            $descuento["precio"] = $value->DesPrecio;
                        }
                        return $descuento;
                    }
                }                
            }
        }        
        return 0;
    }
                  
    
}

