<?php

use App\Controllers\GenericController;
use Marve\Ela\Core\Session;

/*  Todas las llamadas de ajax se redireccionan de aqui            */
set_include_path(get_include_path() . PATH_SEPARATOR . realpath(dirname(__FILE__) . "/../../"));
include_once 'vendor/autoload.php';
try
{
    $partes = explode("/",$_POST["accion"]);
    /* Table/Function/Primary Key  */
    if(count($partes) > 2)
    {
        $controller = new GenericController(Session::getDb(), strtolower($partes[0]), $partes[2]);
    }
    else /* Class/FUnction                              */
    {
        $class = "App\\Controllers\\" . $partes[0];
        $controller = new $class();
    }
    $controller->run($partes[1], $_POST);
}
catch(Exception $ex)
{
    print_r($ex);
}

