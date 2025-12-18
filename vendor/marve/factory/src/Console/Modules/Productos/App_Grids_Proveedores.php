<?php

namespace App\Grids;

class Proveedores
{
    public static function grid($arguments = [])
    {
        return array(
            array(
                "title" => "ID",               
                "name" => "ProvID",           
                "editable" => false,                  
                "width" => "20",          
                "hidden" => true,                 
                "hidedlg" => true,            
                "export" => false),
            array(
                "title" => "Razon Social",
                "name" => "ProvRazon",
                "editable" => $arguments["editar"],
                "width" => "30",
                "link" => $arguments["link"],
                "linkoptions" => $arguments["options"]
            ),
            array(
                "title" => "Telefono",          
                "name" => "ProvTelefono", 
                "editable" => false,                
                "width" => "20",          
                "align" => "center"
            ),
            array(
                "title" => "EMail",
                "name" => "ProvEmail",
                "editable" => $arguments["editar"],
                "width" => "20",
                "align" => "right"
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
        );
    }
}
