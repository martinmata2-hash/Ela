<?php
/**
 * polizas para los archivos y datos
 */

namespace Marve\Ela\Auth;


use Marve\Ela\Core\Model;
use Marve\Ela\Core\Session;

define("PERMISOS_TRUNCATE", 1);
define("PERMISOS_DELETE", 2);
define("PERMISOS_EDIT", 3);
define("PERMISOS_ADD", 4);

abstract class Policy extends Session
{
    
    /**
     * Summary of canDelete
     * @param Model $PERMISO
     * @param string $File
     * @return bool
     */
    static function canDelete(Model $PERMISO, string $File)
    {
        $result = $PERMISO->get("0","","PolUsuario = ".self::getId()." AND PolFile = $File AND PolPolicy = ".PERMISOS_TRUNCATE);
        if($result !== 0 && count($result) > 0) 
            return true;
        else return false;
    }
    
    /**
     * Summary of canEdit     
     * @param Model $PERMISO
     * @param string $File
     * @return bool
     */
    static function canEdit(Model $PERMISO, string $File)
    {
        $result = $PERMISO->get("0","","PolUsuario = ".self::getId()." AND PolFile = $File AND PolPolicy = ".PERMISOS_DELETE);
        if($result !== 0 && count($result) > 0) 
            return true;
        else return false;
    }
    
    /**
     * Summary of canAdd     
     * @param Model $PERMISO
     * @param string $File
     * @return bool
     */
    static function canAdd(Model $PERMISO, string $File)
    {
        $result = $PERMISO->get("0","","PolUsuario = ".self::getId()." AND PolFile = $File AND PolPolicy = ".PERMISOS_EDIT);
        if($result !== 0 && count($result) > 0) 
            return true;
        else return false;
    }

    /**
     * Summary of canView
     * @param Model $PERMISO
     * @param string $File
     * @return bool
     */
    static function canView(Model $PERMISO, string $File)
    {
        $result = $PERMISO->get("0","","PolUsuario = ".self::getId()." AND PolFile = $File AND PolPolicy = ".PERMISOS_ADD);
        if($result !== 0 && count($result) > 0) 
            return true;
        else return false;
    }
}