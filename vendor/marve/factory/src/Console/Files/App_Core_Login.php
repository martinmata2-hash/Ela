<?php

namespace App\Core;

use App\Models\Data\UserD;
use App\Core\User;
use Marve\Ela\Core\Cookie;
use Marve\Ela\Core\CurrentUser;
use Marve\Ela\Core\DotEnv;
use Marve\Ela\Core\Encode;
use stdClass;

class Login extends User
{

    private $cookieoptions = array();
    
    public function __construct()
    {
        parent::__construct(DotEnv::getDB());
        $this->cookieoptions = array("expiry"=>Cookie::AWeek,"path"=>"/","domain"=>true,"secure"=>false, "httponly"=>false,"globalremove"=>true);        
    }
    
    /**
     *
     * @param string $usuario
     * @param string $clave
     * @return UserD|number
     */
    public function login($usuario, $clave)
    {
        $usuario = $this->conection->real_escape_string($usuario);
        $clave = $this->conection->real_escape_string($clave);
        $login = $this->query("*", $this->table, "UsuUsuario = '".$usuario."' AND UsuClave = '".$clave."' AND  UsuActivo = ".POS_ACTIVO);
        if (count($login) > 0)
        {            
            $this->data = new UserD($login[0]);
            $this->resetValues();
            $this->sessionBegin();
            $this->rememberme();
            return $login[0];            
        }
        else
        {
            $this->message = "Usuario o Clave incorrectos";
            return 0;
        }
    }
    
    
    /**
     * Asigna valores en session
     *
     *
     * @return boolean
     */
    private function resetValues()
    {        
        CurrentUser::setRol($this->data->UsuRol);
        CurrentUser::setName($this->data->UsuNombre);
        CurrentUser::setId($this->data->UsuID);
        CurrentUser::setDb($this->data->UsuBd);
        CurrentUser::set("CliID", $this->data->UsuCliente);                        
        //TODO
        /**
         * *** Aqui se pueden agregar otros valores necesarios en session ******
         */
        return true;
            
    }
    
    /**
     * Activar session deb base de datos
     * @return boolean
     */
    private function sessionBegin()
    {
        $data = new stdClass();
        $data->session_id = session_id();
        return ($this->edit($data, $this->data->UsuID, "UsuID") !== 0);
    }
    
    private function rememberme()
    {        
        $token = Encode::createPass(24);
        $data = new stdClass();
        $data->UsuToken = $token;
        $this->edit($data, $this->data->UsuID, "UsuID");
        
        Cookie::Remove("auth",$this->cookieoptions);
        Cookie::Remove("usrtoken",$this->cookieoptions);
        Cookie::Set("auth",session_id(), $this->cookieoptions);
        Cookie::Set("usrtoken",$token,$this->cookieoptions);
        
    }
    
    /**
     * Destruye la session
     *
     * @param int $id
     *
     */
    public function sesionDestroy($id)
    {
        @session_destroy();
        $data = new stdClass();
        $data->session_id = 0;
        $data->token = 0;
        $this->edit($data, $id, "UsuID");
        Cookie::Remove("auth",$this->cookieoptions);
        Cookie::Remove("usrtoken",$this->cookieoptions);
        CurrentUser::remove("CSRF");
    }
    
    /**
     * Activa el recien creado usuario
     *
     * @param int $uid
     * @param string $actcode
     */
    public function activateUser($uid, $actcode)
    {
        $uid = Encode::decode($uid);
        if ($this->query("*", $this->table,  "(UsuID = '$uid' and UsuToken = '$actcode') and UsuActivo = ".POS_INACTIVO) !== 0)
        {
            $datos = new stdClass();
            $datos->UsuActivo = POS_ACTIVO;       
            return $this->edit($datos, $uid, "UsuID");
        }
        return 0;
    }
    
    /**
     * Verifica si El Cliente tiene iniciada Session
     *
     * @return bool
     */
    public function isLoged()
    {
        @session_start();
        if (CurrentUser::getId())
        {
            return true;
        }
        elseif (Cookie::Exists('auth') && Cookie::Get('auth') !== false)
        {
            $credenciales = $this->query("*", $this->table, "UsuToken = '".Cookie::Get("usrtoken")."'");
            if(count($credenciales) > 0)
            {
                $this->data = new UserD($credenciales[0]);
                $this->resetValues();
                $this->sessionBegin();                
                return true;
            }
            else return false;
        }
        else
            return false;       
    }           
    
}
