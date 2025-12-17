<?php
/**
 * Permisos generales para base de datos
 */
namespace Marve\Ela\Core;


define("PERMISOS_TRUNCATE", 1);
define("PERMISOS_DELETE", 2);
define("PERMISOS_EDIT", 3);
define("PERMISOS_ADD", 4);
class CurrentUser extends Session
{

    
    private static function valid($role)
    {
        return $role > 0;
    }
    
    /**
     * Verificar si el usuario tiene permiso de truncate
     *     
     * @return boolean
     */
    static function canTruncate()
    {
        if (self::valid(self::getRol())) return self::getRol() <= PERMISOS_TRUNCATE;
        else return false;
    }
    
    /**
     * Verificar si el usuario tiene permido de borrar
     *     
     * @return boolean
     */
    static function canDelete()
    {
        if (self::valid(self::getRol())) return self::getRol() == PERMISOS_DELETE;
        else return false;
    }
    
    /**
     * Verificar si el usuario tiene permiso de editar
     *     
     * @return boolean
     */
    static function canEdit()
    {
        if (self::valid(self::getRol())) return self::getRol() <= PERMISOS_EDIT;
        else return false;
    }
    
    /**
     * verifica si el usuario tiene permisos de admin
     *     
     * @return boolean
     */
    static function isAdmin()
    {
        if (self::valid(self::getRol())) return self::getRol() <= PERMISOS_DELETE;
        else return false;
    }
    
    /**
     * Verifica si el usuario tiene permiso de supervisor     
     * @return boolean
     */
    static function isSupervisor()
    {
        if(self::valid(self::getRol())) return self::getRol() <= PERMISOS_EDIT;
        else return false;
    }
    
    /**
     * verifica que el usuario tenga permiso de agregar informacion     
     * @return boolean
     */
    static function isUser()
    {
        if(self::valid(self::getRol())) return self::getRol() <= PERMISOS_ADD;
        else return false;
    }  
}

