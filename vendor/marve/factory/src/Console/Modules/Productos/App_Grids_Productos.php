<?php

namespace App\Grids;

class Productos
{
    public static function grid($arguments = [])
    {
        return array(
            array(
                "title" => "ID",                
                "name" => "ProID",                    
                "editable" => false,                  
                "width" => "20",              
                "hidden" => true,             
                "export" => false
            ),
            array(
                "title" => "Updated",
                "name" => "updated",
                "editable" => true,
                "width" => "20",
                "hidden" => true,
                "export" => false,
                "formatter" => "select",
                "edittype" => "select",
                "editoptions" => array("value" => "2:No"),
                "search" => false
            ),
            array(
                "title" => "Codigo",
                "name" => "ProCodigo",
                "editable" => $arguments["editar"],
                "width" => "30",
                "link" => $arguments["link"],
                "linkoptions" => $arguments["options"]
            ),
            array(
                "title" => "Descripcion",       
                "name" => "ProDescripcion",           
                "editable" => $arguments["editar"],   
                "width" => "50",             
                "align" => "left"
            ),
            array(
                "title" => "Aplicacion",     
                "name" => "ProSustancia",              
                "editable" => $arguments["editar"],   
                "width" => "50",             
                "align" => "left"
            ),
            array(
                "title" => "Categoria",
                "name" => "ProCategoria",
                "editable" => $arguments["editar"],
                "width" => "30",
                "formatter" => "select",
                "edittype" => "select",
                "editoptions" => array("value" => "-1:seleciona;" . $arguments["categorias"]),
                "op" => "eq",
                "searchoptions" => array("value" => "-1:seleciona;" . $arguments["categorias"]),
                "stype" => "select"
            ),
            array(
                "title" => "Ubicacion",         
                "name" => "ProUbicacion",                
                "editable" => $arguments["editar"],                  
                "width" => "30"
            ),
            //"formatter"=>"select",          "edittype"=>"select", "editoptions"=>array("value"=>"-1:seleciona;".$arguments["subcat"]),       "op"=>"eq",
            //"searchoptions"=>array("value"=>"-1:seleciona;".$arguments["subcat"]),           "stype"=> "select"  ),
            //array("title"=>"Unidad",            "name"=>"ProUnidad",                "editable"=>false,                  "width"=>"20"),
            //array("title"=>"Producto Servicio", "name"=>"ProProSer",                "editable"=>false,                  "width"=>"20"),
            array(
                "title" => "Existencias",       
                "name" => "InvCantidad",              
                "editable" => false,                  
                "width" => "20",              
                "align" => "right"
            ),
            array(
                "title" => "Precio",            
                "name" => "ProPrecio",                
                "editable" => $arguments["editar"],   
                "width" => "20",              
                "align" => "right"
            ),
            array(
                "title" => "Precio 2",
                "name" => "ProPrecio2",
                "editable" => $arguments["editar"],
                "width" => "20",
                "align" => "right"
            ),
            array(
                "title" => "Precio 3",
                "name" => "ProPrecio3",
                "editable" => $arguments["editar"],
                "width" => "20",
                "align" => "right"
            ),
            array(
                "title" => "Proveedor",
                "name" => "ProProveedor",
                "editable" => $arguments["editar"],
                "width" => "30",
                "align" => "left",
                "formatter" => "select",
                "edittype" => "select",
                "editoptions" => array("value" => "-1:seleciona;" . $arguments["proveedores"]),
                "op" => "eq",
                "searchoptions" => array("value" => "-1:seleciona;" . $arguments["proveedores"]),
                "stype" => "select"
            ),
            array(
                "title" => "Costo",
                "name" => "ProCompra",
                "editable" => $arguments["editar"],
                "width" => "20",
                "align" => "right",
                "hidden" => !$arguments["editusuario"],
                "hidedlg" => !$arguments["editusuario"]
            ),
            //array("title"=>"Antibiotico",       "name"=>"ProAntibiotico",           "editable"=>false,                  "width"=>"20",              "align"=>"right",            "export"=>false)            

        );
    }
}
