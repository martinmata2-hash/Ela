<?php

use App\Controllers\GenericController;
use App\Core\Login;
use Marve\Ela\Core\Session;

/*  Todas las llamadas de ajax se redireccionan de aqui            */
set_include_path(get_include_path() . PATH_SEPARATOR . realpath(dirname(__FILE__) . "/../../"));

include_once 'vendor/autoload.php';
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
header("Access-Control-Allow-Origin: *");
@session_start();


try
{
    if(isset($_POST["credenciales"]))
    {
        $USUARIO = new Login();
        $usuario = explode('@',$_POST["credenciales"]); 
        $loged = $USUARIO->login($usuario[0], $usuario[1]);
        if(isset($loged->UsuID))
        {            
            unset($_POST["credenciales"]);
            $_POST["token"] = Session::getCsrf();
        }
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
    
}
catch(Exception $ex)
{
    print_r($ex);
}
