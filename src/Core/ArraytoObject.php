<?php
namespace Marve\Ela\Core;

use Exception;
use stdClass;

/**
 * @version v2024_1
 * @author Martin Mata
 */

/**
 * Convierte array a object stdclass
 * @author Martin
 *
 */
class ArraytoObject
{
    /**
     * Converte lo contenido en post, get o un array a una clase
     * @param array $array
     * @param stdClass $class
     */
    static function convertir($array, $class = null)
    {
        if(!is_object($class))
        {
            $class = new stdClass();
        }
        try
        {
            foreach ($array as $key => $value)
            {
                if(is_array($value))
                {
                    $class->$key = self::convertir($value);                    
                }
                else $class->$key = $value;
            }
        }
        catch (Exception $e)
        {;}
        return $class;
    }

    static function encuentra($array, $nombre, $elemento)
    {
        foreach ($array as $key => $v)
        {
            if($v->$nombre == $elemento)
            {
                return $key;                
            }                                                
        }
        return -1;
    }
}
