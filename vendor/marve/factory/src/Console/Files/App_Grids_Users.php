<?php

namespace App\Grids;

class Users
{
    public static function grid($arguments = [])
    {
         return array(
            array(
                "title" => "ID",               
                "name" => "UsuID",                
                "editable" => false,                              
                "width" => "40",              
                "hidden" => true,                 
                "hidedlg" => true,            
                "export" => false),
            array(
                "title" => "Nombre",
                "name" => "UsuNombre",
                "editable" => $arguments["editar"],
                "width" => "100",
                "align" => "center",
                "link" => $arguments["link"],
                "linkoptions" => "class='box'"
            ),
            array(
                "title" => "Rol",
                "name" => "UsuRol",
                "editable" => $arguments["editar"],
                "width" => "40",
                "align" => "center",
                "editoptions" => array("value" => $arguments["rol"]),
                "edittype" => "select",
                "op" => "eq",
                "formatter" => "select",
                "searchoptions" => array("value" => "0:SELECCIONA;" . $arguments["rol"]),
                "stype" => "select"
            ),          
            array(
                "title" => "Activo",
                "name" => "UsuActivo",
                "editable" => $arguments["editar"],
                "width" => "20",
                "align" => "left",
                "formatter" => "checkbox",
                "edittype" => "checkbox",
                "editoptions" => array("value" => "1:0")
            ),
            array(
                "title" => "Permisos",
                "name" => "permisos",
                "editable" => false,
                "width" => "20",
                "align" => "left",
                "search" => false,
                "default" => $arguments["permiso"]
            )
        );
    }
}