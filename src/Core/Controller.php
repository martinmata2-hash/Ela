<?php
namespace Marve\Ela\Core;
use stdClass;

define("CONTROLLER_ELIMINADO", 1);
define("CONTROLLER_ACTIVO", 1);
define("CONTROLLER_INACTIVO", 0);
define("CONTROLLER_SUCCESS", 200);
define("CONTROLLER_ERROR", 400);
define("CONTROLLER_DATOS_VALIDOS",20);
define("CONTROLLER_DATOS_INVALIDOS",40);
abstract class Controller
{
    
    protected $status;
    protected $request;
    protected $message;

    protected $class;
        
    protected function render()
    {
        return json_encode(array("status" => $this->status,"request" => $this->request,"message" => $this->message));
    }
    
    public function run($metodo, $arguments) 
    {
        if(method_exists($this,$metodo))
        {            
            if(is_array($arguments["data"]))
                $datos = $arguments["data"];
            else
                parse_str($arguments["data"], $datos);
            if($this->before($arguments["token"],$datos))
            {
                $request = $this->$metodo($datos);
                $this->after($request,$this->class->message);
            }
            echo $this->render();
        }
        else
        {
            $this->status = CONTROLLER_DATOS_INVALIDOS;
            $this->request = 0;
            $this->message = "La peticion no puede ser procesada, Datos Invalidados";   
            echo $this->render();
        }
	}
    
    protected function before($token, &$data)
    {               
        if( isset($this->status) &&  $this->status == CONTROLLER_DATOS_INVALIDOS)
            return false;
        if($token === Session::getCsrf())
        {
            if(isset($data["CSRF"]))
                unset($data["CSRF"]);
            if(is_iterable($data))
            {
                $data = ArraytoObject::convertir($data);
                foreach ($data as $key => $value) 
                {
                    if(!is_object($value))                                        
                        $data->$key = $this->class->conection->real_escape_string($value); 
                }
            }
            return true;
        }
        else
        {
            $this->status = CONTROLLER_DATOS_INVALIDOS;
            $this->request = 0;
            $this->message = "La sesión terminó, Presione F5 para continuar";               
            return false;
        }        
    }
    
    protected function after($request,$message)
    {
        if(is_array($request))
        {
            if(count($request) > 0)
            {
                $this->status = CONTROLLER_SUCCESS;
                $this->request = ArraytoObject::convertir($request);
            }
            else 
            {
                $this->status = CONTROLLER_ERROR;
                $this->request = 0;
            }
        }
        elseif($request === 0)
        {
            $this->status = CONTROLLER_ERROR;
            $this->request = 0;
        }
        else
        {
            $this->status = CONTROLLER_SUCCESS;
            $this->request = $request;
        }
        if(is_array($message))
        {
            if(count($message) > 0)
                $this->message = ArraytoObject::convertir($message);
            else $this->message = 0;
        }
        else
        {
            $this->message = $message;
        }
        
    }
}

