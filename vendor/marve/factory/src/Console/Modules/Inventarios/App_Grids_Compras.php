<?php

namespace App\Grids;

class Compras
{
    public static function grid($arguments = null)
    {
        return
        array(
                array(
                    "title" => "ID",
                    "name" => "FacID",
                    "editable" => false,
                    "align" => "center",
                    "width" => "10",
                    "link" => $arguments["link"],
                    "linkoptions" => $arguments["options"]
                ),
                array(
                    "title" => "Proveedor",         
                    "name" => ($arguments["proveedor"])??"ProvRazon",        
                    "editable" => false,      
                    "align" => "center",      
                    "width" => "15"
                ),
                array(
                    "title" => "Folio",             
                    "name" => "FacFolio",        
                    "editable" => false,      
                    "align" => "center",      
                    "width" => "15"
                ),
                /*
            array("title"=>"Cancelada",     "name"=>"FacCancelada", "editable"=>true,       "align"=>"center",      "width"=>"10",
                "search"=>false,            "edittype"=>"select",   "editoptions"=>array("value"=>"1:SI;0:NO"),     "op"=>"eq",
                "value"=>"SI",              "css"=>"'background-color':'Bisque'"),
            */
                array(
                    "title" => "Fecha",         
                    "name" => "FacFecha",      
                    "editable" => true,      
                    "align" => "center",      
                    "width" => "15"
                ),
                array(
                    "title" => "Total",         
                    "name" => "FacTotal",     
                    "editable" => false,      
                    "align" => "right",       
                    "width" => "15",          
                    "search" => true
                ),
                array(
                    "title" => "Usuario",
                    "name" => "FacUsuario",
                    "editable" => $arguments["editar"],
                    "width" => "10",
                    "align" => "center",
                    "hidden" => !$arguments["editar"],
                    "editoptions" => array("value" => "-1:SELECCIONA;" . $arguments["usuarios"]),
                    "formatter" => "select",
                    "searchoptions" => array("value" => "-1:SELECCIONA;" . $arguments["usuarios"]),
                    "stype" => "select"
                ),
                array(
                    "title" => "Imprimir",
                    "name" => "print",
                    "editable" => false,
                    "width" => "5",
                    "align" => "left",
                    "search" => false,
                    "default" => $arguments["imprimir"]
                )
            );
    }
}
