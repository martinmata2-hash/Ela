<?php
namespace Marve\Ela\Core;

/**
 * Formateo de respuestas ajax
 * @author Marti
 *
 */
class Response
{
    
    static function result($status, $result = 0, $message = "")
    {
        return json_encode(array("status" => $status,"result" => $result,"message" => $message));
    }
}

