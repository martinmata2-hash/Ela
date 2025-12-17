<?php
namespace Marve\Ela\MySql;

use Marve\Ela\Core\DotEnv;
use mysqli;

class Single
{
    private static $instance;
    /**
     * Conexion a bd
     * @var mysqli
     */
    private $con;
    private function __construct(){}

    private static function getInstance()
    {
        if(self::$instance == null)
        {            
            self::$instance = new Single();
            self::$instance->con = new mysqli(DotEnv::getHost(), DotEnv::getUser(), DotEnv::getPassword(), DotEnv::getDB());
        }
        return self::$instance;
    }

    private static function initConnection()
    {
        $db = self::getInstance();        
        return $db; 
    }

    public static function getConection()
    {       
        $db = self::initConnection();
        return $db->con;       
    }
}