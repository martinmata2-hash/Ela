<?php
namespace App\Controllers;

use Marve\Ela\Controllers\ModelController;
use Marve\Ela\Core\CurrentUser;
use Marve\Ela\Core\Encode;
use stdClass;

class Login extends ModelController
{    
    /**
     */
    public function __construct() 
    {                          
        $this->class =  new \App\Core\Login();
        $this->key = "UsuID";
    }
    
   /**
	 * Logea en el sistema
	 * @param mixed $datos
	 * @return number|string
	 */
    protected function login($datos)
    {
        $respuesta = $this->class->login(Encode::sha1md5encode($datos->usuario), Encode::sha1md5encode($datos->clave));    
        if($respuesta !== 0)
        {    
            if(CurrentUser::isSupervisor())	
                $this->request = "/Dashboard/Ventas";  #TODO redireccionar
            else
                $this->request = "/Dashboard/Catalogos";    #TODO redireccionar
        }
        else 
        {
            $this->request = 0;            
        }        
        return $this->request;
    }

    /**
     * Registra usuarios
     * @param mixed $datos
     * @return number|string
     */
    protected function store($datos)
    {        
        if((isset($datos->UsuID) && $datos->UsuID > 0))
        {
           if (isset($datos->UsuUsuario) && strlen($datos->UsuUsuario) < 20)
            {
                $datos->UsuUsuario = Encode::sha1md5encode($datos->UsuUsuario);                
            }
            if (isset($datos->UsuClave) && strlen($datos->UsuClave) < 20)
            {
                $datos->UsuClave = Encode::sha1md5encode($datos->UsuClave);
            }            
            if($this->class->exists($this->key, $datos->UsuID))
                $this->request = $this->class->edit($datos,$datos->UsuID, $this->key);      
            else
                $this->request = $this->class->store($datos);                 
        }
        else
        {
            $datos->UsuUsuario = Encode::sha1md5encode($datos->UsuUsuario);
            $datos->UsuClave = Encode::sha1md5encode($datos->UsuClave);
            $this->request = $this->class->store($datos);                
        }                                      
        return $this->request;        
    }        
}
