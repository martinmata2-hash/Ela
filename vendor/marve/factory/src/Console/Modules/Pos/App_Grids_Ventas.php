<?php

namespace App\Grids;

class Ventas
{
    public static function grid($arguments = null)
    {
       return array(
            array(
                "title" => "ID",                    
                "name" => "id",               
                "editable" => false,          
                "width" => "10",      
                "align" => "center",      
                "hidden" => true,         
                "search" => false),
            array(
                "title" => "Adeudo",                
                "name" => "deuda",            
                "editable" => false,          
                "width" => "10",      
                "align" => "center",      
                "hidden" => true,         
                "search" => false),
            array(
                "title" => "FOLIO<br><small>Devolucion</small>",
                "name" => "FacID",
                "editable" => false,
                "width" => "10",
                "align" => "center",
                "link" => $arguments["link"],
                "linkoptions" => $arguments["option"]
            ),
            array(
                "title" => "Cliente",               
                "name" => "CliNombre",        
                "editable" => false,          
                "width" => "20",     
                "align" => "center"),
            array(
                "title" => "Fecha",                 
                "name" => "FacFecha",         
                "editable" => false,          
                "width" => "10",     
                "align" => "center",      
                "hidden" => $arguments["hiden"]),
            array(
                "title" => "Total<br><small>Timbrar Venta</small>",
                "name" => "FacTotal",
                "editable" => false,
                "width" => "10",
                "align" => "center",
                "link" => $arguments["link2"],
                "hidden" => $arguments["hiden"],
                "linkoptions" => $arguments["options"]
            ),
            array(
                "title" => "Forma Pago",
                "name" => "FacFormaPago",
                "editable" => false,
                "width" => "10",
                "align" => "center",
                "edittype" => "select",
                "editoptions" => $arguments["formapago"],
                "formatter" => "select",
                "searchoptions" => $arguments["formapago"],
                "stype" => "select"
            ),
            array(
                "title" => "Usuario",
                "name" => "FacUsuario",
                "editable" => false,
                "width" => "20",
                "align" => "center",
                "hidden" => $arguments["hiden"],
                "editoptions" => array("value" => "-1:SELECCIONA;" . $arguments["usuarios"]),
                "formatter" => "select",
                "searchoptions" => array("value" => "-1:SELECCIONA;" . $arguments["usuarios"]),
                "stype" => "select"
            ),
            array(
                "title" => "Factura",                   
                "name" => "FacDatos",         
                "editable" => false,          
                "width" => "10",      
                "align" => "center"),
            array(
                "title" => "Imprimir",
                "name" => "print",
                "editable" => false,
                "width" => "10",
                "align" => "left",
                "search" => false,
                "hidden" => $arguments["hiden"],
                "default" => $arguments["imprimir"]
            )
        );
    }
}
