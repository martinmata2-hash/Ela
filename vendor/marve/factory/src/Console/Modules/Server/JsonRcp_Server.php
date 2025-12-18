<?php

use App\Core\Login;
use Marve\Ela\Core\ArraytoObject;
use Marve\Ela\Core\Response;

set_include_path(get_include_path() . PATH_SEPARATOR . realpath(dirname(__FILE__) . "/../"));

include_once 'vendor/autoload.php';
include_once 'init.php';
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
@session_start();
$input = file_get_contents('php://input');
$req = json_decode($input, true);
if(isset($req["params"]) && !empty($req["params"]))
{
    $params = $req["params"]; 
    if(isset($params["credenciales"]))
    {
        $credenciales = explode("@",$params["credenciales"]);
        $loged = (new Login())->login($credenciales[1],$credenciales[0]);
        unset($params["credenciales"]);
        if(class_exists($params["method"],true))
        {
            $myClass = new $params["method"];
            $sufix = "";
            $key = "";
            $id = 0;
            foreach ($param["data"] as $key => $value) 
                {
                   $sufix =  substr($key, 0, 4);
                   if($sufix != "Prov")
                        $sufix =  substr($key, 0, 3);
                   break;
                }
            $key = $sufix ."ID";
            if($params["action"] == 0)
            {
                $id = $myClass->store(ArraytoObject::convertir($params["data"]));
            }
            else
            {                                
                $data = ArraytoObject::convertir($params["data"]);
                $id = $myClass->edit($data,$data->{$key},$key);                
            }
            echo Response::result(POS_SUCCESS,[$key,$id],$myClass->message);
        }
        else echo Response::result(POS_ERROR,0,"incorrect class call");
    }
    else echo Response::result(POS_DATOS_INVALIDOS,0,"incorrect credentials");
}
else echo Response::result(POS_ERROR,0,"incorrect call");