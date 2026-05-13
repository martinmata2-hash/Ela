<?php
namespace Marve\Ela\Core;

/**
 * Formateo de respuestas ajax
 * @author Marti
 *
 */
class Response
{
    /**
     * Summary of result
     * @param mixed $status
     * @param mixed $result
     * @param mixed $message
     * @return bool|string
     */
    static function result($status, $result = 0, $message = "")
    {
        return json_encode(array("status" => $status,"result" => $result,"message" => $message));
    }
}
