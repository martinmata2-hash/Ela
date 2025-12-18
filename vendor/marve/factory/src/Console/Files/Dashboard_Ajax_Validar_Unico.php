<?php

use App\Core\User;
use Marve\Ela\Core\Encode;
use Marve\Ela\Core\Generic;
use Marve\Ela\Core\Response;
use Marve\Ela\Core\Session;

/**
 * Verifica que el campo sea unico
 * @version v2023_1
 * @author Martin Mata
 */
set_include_path(get_include_path() . PATH_SEPARATOR . realpath(dirname(__FILE__) . "/../../../"));

include_once 'vendor/autoload.php';
@session_start();


define("VALIDAR_DATO_INVALIDO",400);
define("VALIDAR_DATO_VALIDO", 200);
if(isset($_POST["validar"]) && $_POST["validar"] == "unico")
{
    if($_POST["tipo"] == "Usuario")
    {
        $USUARIO = new User();
        if($_POST["campo"] == "UsuUsuario")
            $_POST["value"] = Encode::sha1md5encode($_POST["value"]);
        $respuesta = $USUARIO->exists($_POST["campo"],$_POST["value"]);
        if($respuesta === true)
            echo Response::result(VALIDAR_DATO_INVALIDO,0,"Duplicado");
        else echo Response::result(VALIDAR_DATO_VALIDO,1,"OK");
    }
    else 
    {
        $UNICO = new Generic(Session::getDb(), strtolower($_POST["tipo"]));
        $respuesta = $UNICO->exists($_POST["campo"],$_POST["value"]);
        if($respuesta === true)
            echo Response::result(VALIDAR_DATO_INVALIDO,0,"Duplicado");
        else echo Response::result(VALIDAR_DATO_VALIDO,1,"OK");
    }
}
else  echo Response::result(VALIDAR_DATO_INVALIDO, 0, "No hay datos");


