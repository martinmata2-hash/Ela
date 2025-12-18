<?php


use App\Core\Login;
use Marve\Ela\Core\Response;
use Marve\Ela\Validation\DirectValidator;

use const Dom\VALIDATION_ERR;

/**
 * Validaciones de datos
 * @version 1.0 
 * @author Martin Mata
 */
set_include_path(get_include_path() . PATH_SEPARATOR . realpath(dirname(__FILE__) . "/../../../"));

include_once 'vendor/autoload.php';
@session_start();

$LOGIN = new Login();

define("VALIDAR_DATO_INVALIDO",400);
define("VALIDAR_DATO_VALIDO", 200);
switch ($_POST["validar"])
{
    case "nombre":
        $respuesta = DirectValidator::Name($_POST["value"],2);
        if($respuesta !== true)
            echo Response::result(VALIDAR_DATO_INVALIDO,0,$respuesta);
        else echo Response::result(VALIDAR_DATO_VALIDO,1,"OK");
        break;
    case "usuario":
        $respuesta = DirectValidator::User($_POST["value"],4);
        if($respuesta !== true)
            echo Response::result(VALIDAR_DATO_INVALIDO,0,$respuesta);
        else
        {           
           echo Response::result(VALIDAR_DATO_VALIDO,1,"OK");          
        }
        break;
    case "email":
        $respuesta = DirectValidator::Email($_POST["value"]);
        if($respuesta !== true)
            echo Response::result(VALIDAR_DATO_INVALIDO,0,$respuesta);
            else echo Response::result(VALIDAR_DATO_VALIDO,1,"OK");
            break;
    case "clave":
        $respuesta = DirectValidator::Password($_POST["value"]);
        if($respuesta !== true)
            echo Response::result(VALIDAR_DATO_INVALIDO,0,$respuesta);
        else echo Response::result(VALIDAR_DATO_VALIDO,1,"OK");
        break;
    case "telefono":
        $respuesta = DirectValidator::Telefone($_POST["value"]);
        if($respuesta !== true)
            echo Response::result(VALIDAR_DATO_INVALIDO,0,$respuesta);
            else echo Response::result(VALIDAR_DATO_VALIDO,1,"OK");
            break;
    case "rfc":
        $respuesta = DirectValidator::Rfc($_POST["value"]);
        if($respuesta !== true)
            echo Response::result(VALIDAR_DATO_INVALIDO,0,$respuesta);
        else echo Response::result(VALIDAR_DATO_VALIDO,1,"OK");
        break;
    case "codigo":
        $respuesta = DirectValidator::Barcode($_POST["value"]);
        if($respuesta !== true)
            echo Response::result(VALIDAR_DATO_INVALIDO,0,$respuesta);
        else echo Response::result(VALIDAR_DATO_VALIDO,1,"OK");            
        break;
    case "numero":
        $respuesta = DirectValidator::Numero($_POST["value"]);
        if($respuesta !== true)
            echo Response::result(VALIDAR_DATO_INVALIDO,0,$respuesta);
            else echo Response::result(VALIDAR_DATO_VALIDO,1,"OK");
            break;
    default:
        echo Response::result(VALIDATION_ERR, 0, "No hay datos");
        break;
}

