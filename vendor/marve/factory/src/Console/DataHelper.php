<?php
namespace Marve\Factory\Console;

use Marve\Ela\Core\DotEnv;
use Marve\Ela\MySql\Query;

class DataHelper extends Query
{
    function __construct() 
    {
        parent::__construct(DotEnv::getDB());        
    }
        
    /**
     * 
     * @param string $tabla
     * @return array
     */
    protected function getFields($tabla): array
    {
        $datos = array();
        $tabla = $this->conection->real_escape_string($tabla);    
        $fields = $this->conection->query("show columns from $tabla");       
        while ($fila = $fields->fetch_object())
        {
            $datos[] = $fila;
        }       
        return $datos;
    }
    public function getDataMembers($tabla)
    {
        $datos = $this->getFields($tabla);
                
        $datamembers =  "";
        $public = "";
        foreach ($datos as $value) 
        {                        
            if(substr($value->Type, 0,3) == "int")
            {
                $asignation = " = 0;";
                $documentation = "/**\n* @var int\n*\n*/";
            }
            else 
            {
                $asignation = " = \"\";";
                $documentation = "/**\n* @var string\n*\n*/\n";
            }
            $public .= $documentation."public $".$value->Field.";\n";
            $datamembers .= "$"."this->".$value->Field.$asignation."\n";
        }
        return array("public"=>$public, "datamembers"=>$datamembers);
    }
    
    public function createTable($tabla)
    {
        $datos = array();
        $result = $this->conection->query("show create table $tabla");
        while ($fila = $result->fetch_array())
        {
            $datos = $fila;
        }
        return $datos;
    }
    
}