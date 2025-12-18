<?php 

namespace App\Grids;

class Cajas
{

     public static function grid($arguments = [])
     {
        $descripcion = "Descripcion<br><small>Mostrar Actividad</small>";
        return array(
            array(
                "title" => "ID",              
                "name" => "FluID",              
                "editable" => false,                
                "width" => 10,              
                "align" => "center",                
                "export" => false
            ),
            array(
                "title" => $descripcion,
                "name" => "FluDescripcion",
                "editable" => false,
                "width" => 40,
                "align" => "left",
                "link" => $arguments["link"],
                "linkoptions" => "class='box'"
            ),
            array(
                "title" => "Fecha",           
                "name" => "FluFecha",           
                "editable" => false,                
                "width" => 20,              
                "align" => "center"
            ),
            array(
                "title" => "Cantidad",
                "name" => "FluCantidad",
                "editable" => false,
                "width" => 20,
                "align" => "right",
                "search" => false,
                "formatter" => "currency",
                "formatoptions" => array("prefix" => "$",  "suffix" => '', "thousandsSeparator" => ",",  "decimalSeparator" => ".", "decimalPlaces" => 2)
            ),
            array(
                "title" => "Usuario",
                "name" => "FluUsuario",
                "editable" => false,
                "width" => 20,
                "align" => "center",
                "editoptions" => array("value" => "-1:SELECCIONA;" . $arguments["usuarios"]),
                "formatter" => "select",
                "searchoptions" => array("value" => "-1:SELECCIONA;" . $arguments["usuarios"]),
                "stype" => "select"
            ),
            array(
                "title" => "Codigo",
                "name" => "FluCodigo",
                "editable" => false,
                "width" => 80,
                "align" => "center",
                "hidden" => true,
                "export" => false
            ),
            array(
                "title" => "Documento",
                "name" => "FluRelacion",
                "editable" => false,
                "width" => 60,
                "align" => "left",
                "hidden" => true,
                "export" => false
            ));
     }
}
