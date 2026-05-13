<?php
/**
 * Permisos generales para base de datos
 */
namespace Marve\Ela\Core;

use Marve\Ela\Auth\Policy;

class CurrentUser extends Policy
{

    /**
     * Summary of valid
     * @param int $role
     * @return bool
     */
    private static function valid($role)
    {
        return $role > 0;
    }

    static function isSuperAdmin()
    {
        if (self::valid(self::getRol())) 
            return self::getRol() == PERMISOS_TRUNCATE;
        else 
            return false;
    }
        
    /**
     * verifica si el usuario tiene permisos de admin
     *     
     * @return boolean
     */
    static function isAdmin()
    {
        if (self::valid(self::getRol())) 
            return self::getRol() <= PERMISOS_DELETE;
        else 
            return false;
    }
    
    /**
     * Verifica si el usuario tiene permiso de supervisor     
     * @return boolean
     */
    static function isSupervisor()
    {
        if(self::valid(self::getRol())) 
            return self::getRol() <= PERMISOS_EDIT;
        else 
            return false;
    }
    
    /**
     * verifica que el usuario tenga permiso de agregar informacion     
     * @return boolean
     */
    static function isUser()
    {
        if(self::valid(self::getRol())) 
            return self::getRol() <= PERMISOS_ADD;
        else 
            return false;
    }  
}
