<?php


/**
 * Clase con datos de include y define, para auto include los archivos que contienen clases
* se incluyen al momento en que la clase es llamada
* @author Martin
*
*/

@session_start();

//error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
//ini_set("display_errors","off");
date_default_timezone_set("America/Mexico_City");
//Definiciones para estandarizar valores
define("POS_ELIMINADO", 1);
define("POS_ACTIVO", 1);
define("POS_INACTIVO", 0);
define("POS_SUCCESS", 200);
define("POS_ERROR", 400);
define("POS_DATOS_VALIDOS",200);
define("POS_DATOS_INVALIDOS",400);

if (!function_exists('dd')) {
    function dd(...$vars) {
        echo '<pre style="background:#f9f9f9;border:1px solid #ccc;padding:10px;font-family:monospace;">';
        foreach ($vars as $var) {
            var_dump($var);
        }
        echo '</pre>';
        die(1);
    }
}