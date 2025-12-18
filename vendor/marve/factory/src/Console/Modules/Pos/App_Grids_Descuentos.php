<?php

namespace App\Grids;

class Descuentos
{
    public static function grid($arguments = [])
    {
        return array(
            array(
                "title" => "ID",                       
                "name" => "DesID",            
                "editable" => false,                  
                "width" => "20",          
                "hidden" => true,                 
                "hidedlg" => true,            
                "export" => false
            ),
            array(
                "title" => "Descuento / Promoción",
                "name" => "tipo",
                "editable" => false,
                "width" => "20",
                "align" => "left",
                "link" => $arguments["link"],
                "linkoptions" => $arguments["options"]
            ),
            array(
                "title" => "Descripcion",               
                "name" => "DesDescripcion",   
                "editable" => $arguments["editar"],   
                "width" => "40",         
                "align" => "left"
            ),
            array(
                "title" => "Inicia",                    
                "name" => "DesInicia",        
                "editable" => $arguments["editar"],   
                "width" => "10"
            ),
            array(
                "title" => "Termina",                   
                "name" => "DesTermina",       
                "editable" => $arguments["editar"],   
                "width" => "10",          
                "align" => "center"
            ),
            array(
                "title" => "Precio / Descuento",        
                "name" => "precio",           
                "editable" => false,                  
                "width" => "10",          
                "align" => "center"
            ),
            array(
                "title" => "Condicion",
                "name" => "DesCondicion",
                "editable" => false,
                "width" => "20",
                "align" => "left"
            )
        );
    }
}   