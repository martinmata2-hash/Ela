<?php

namespace Marve\Ela\Core;

class Session
{
             
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key)
    {
        return $_SESSION[$key]?? false;
    }

    public static function remove($key)
    {
        unset($_SESSION[$key]);
    }

    public static function setRol($value)
    {
         self::set("USR_ROL", $value);
    }
    public static function getRol()
    {
        return self::get("USR_ROL");
    }
    
    public static function setName($value)
    {
         self::set("USR_NOMBRE", $value);
    }
    public static function getName()
    {
        return self::get("USR_NOMBRE");
    }

    public static function getId()
    {
        return self::get("USR_ID");
    }

    public static function setId($value)
    {
        self::set("USR_ID", $value);
    }

    public static function getDb()
    {
        return self::get("USR_BD");
    }

    public static function setDb($value)
    {
        self::set("USR_BD", $value);
    }

    public static function getBussiness()
    {
        return self::get("USR_EMPRESA");
    }

    public static function setBussiness($value)
    {
        self::set("USR_EMPRESA", $value);
    }

    public static function getStore()
    {
        return self::get("TIENDA");
    }

    public static function setStore($value)
    {
        self::set("TIENDA", $value);
    }

    public static function getStoreName()
    {
        return self::get("TIENDA_NOMBRE");
    }

    public static function setStoreName($value)
    {
        self::set("TIENDA_NOMBRE", $value);
    }

    public static function getUserPac()
    {
        return self::get("USR_USUARIO_PAC");
    }

     public static function setUserPac($value)
    {
        self::set("USR_USUARIO_PAC", $value);
    }

    public static function getUser()
    {
        return self::get("USR_USUARIO");
    }

     public static function setUser($value)
    {
        self::set("USR_USUARIO", $value);
    }

    public static function getPasswordPac()
    {
        return self::get("USR_CLAVE_PAC");
    }

    public static function setPassword($value)
    {
        self::set("USR_CLAVE", $value);
    }
    public static function getPassword()
    {
        return self::get("USR_CLAVE");
    }

     public static function setPasswordPac($value)
    {
        self::set("USR_CLAVE_PAC", $value);
    }

     public static function setCsrf()
    {
        if(!isset($_SESSION["CSRF"]))
            $_SESSION["CSRF"] = session_id();        
    }
     public static function getCsrf()
    {
        if(!isset($_SESSION["CSRF"]))
            $_SESSION["CSRF"] = session_id();
        return self::get("CSRF");
    }

    public static function getPacCredenciales()
    {
        return self::getPasswordPac()."@".self::getUserPac();
    }

    public static function getCredenciales()
    {
        return self::getPassword()."@".self::getUser();
    }

}