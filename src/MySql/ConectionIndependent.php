<?php
namespace Marve\Ela\MySql;

use Marve\Ela\Core\DotEnv;

abstract class ConectionIndependent
{    
    public $conection;
    public $data_base;
    public function __construct(string $data_base)
    {
        $this->conection = new \mysqli(DotEnv::getHost(), DotEnv::getUser(), DotEnv::getPassword(), $data_base);
        $this->data_base = $data_base;
    }
    
    /**
     * 
     * @param string $data_base
     * @return bool
     */
    protected function isConected($data_base = null):bool
    {
        if($data_base !== null)
            $this->data_base = $data_base;
        if($this->conection->ping())
            return true;
        else
            return $this->conection->real_connect(DotEnv::getHost(), DotEnv::getUser(), DotEnv::getPassword(), $this->data_base);        
    }
    
    /**
     *
     * @param string $data_base
     * @return bool
     */
    protected function selectDB(string $data_base):bool
    {
        $this->data_base = $data_base;
        return $this->conection->select_db($data_base);
    }
    
    /**
     * 
     * @param string $name
     * @return bool|\mysqli_result
     */
    protected function createDB(string $name)
    {
        $name = $this->conection->real_escape_string($name);
        $query = "CREATE DATABASE IF NOT EXISTS $name DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci";
        return $this->conection->query($query);
    }
}
