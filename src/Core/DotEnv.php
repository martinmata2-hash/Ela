<?php 
namespace Marve\Ela\Core;

use Exception;

class DotEnv {
    private static $path;
    private static $tmp_env;
    private static function init()
    {
        $env_path = $_SERVER['DOCUMENT_ROOT']."/.env";
        // Check if .env file path has provided
        if(empty($env_path)){
            throw new Exception(".env file path is missing $env_path");
        }
        self::$path = $env_path;

        //Check .envenvironment file exists
        if(!is_file(realpath(self::$path))){
            throw new Exception("Environment File is Missing. $env_path");
        }
        //Check .envenvironment file is readable
        if(!is_readable(realpath(self::$path))){
            throw new Exception("Permission Denied for reading the ".(realpath(self::$path)).".");
        }
        self::$tmp_env = [];
        $fopen = fopen(realpath(self::$path), 'r');
        if($fopen)
        {
            while (($line = fgets($fopen)) !== false)
            {
                // Check if line is a comment
                $line_is_comment = (substr(trim($line),0 , 1) == '|') ? true: false;
                if($line_is_comment || empty(trim($line)))
                    continue;

                $line_no_comment = explode("|", $line, 2)[0];
                $env_ex = preg_split('/(\s?)\=(\s?)/', $line_no_comment,2);
                $env_name = trim($env_ex[0]);
                $env_value = isset($env_ex[1]) ? trim($env_ex[1]) : "";
                self::$tmp_env[$env_name] = $env_value;
            }
            fclose($fopen);
        }
        self::load();
    }

    private static function load(){
        // Save .env data to Environment Variables
        foreach(self::$tmp_env as $name=>$value){
            putenv("{$name}=$value");
            if(is_numeric($value))
            $value = floatval($value);
            if(in_array(strtolower($value),["true","false"]))
            $value = (strtolower($value) == "true") ? true : false;
            $_ENV[$name] = $value;
        }        
    }
 
    public static function get($key)
    {
        return $_ENV[$key]?? false;
    }

    /**
     * Summary of getHost
     */
    public static function getHost(): string
    {
        if(!isset($_ENV['DB_HOST']))
            self::init();
        return $_ENV['DB_HOST'];
    }
    public static function getDB(): string
    {
        if(!isset($_ENV['DB_NAME']))
            self::init();
        return $_ENV['DB_NAME'];
    }
    public static function getUser(): string
    {
        if(!isset($_ENV['DB_USER']))
            self::init();
        return $_ENV['DB_USER'];
    }

    public static function getPassword(): string
    {
        if(!isset($_ENV['DB_PASSWORD']))
            self::init();
        return $_ENV['DB_PASSWORD'];
    }
}