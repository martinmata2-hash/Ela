<?php
/**
 * Clase abstracta para extender en las clases que usen base de datos
 */
namespace Marve\Ela\Core;


use Marve\Ela\MySql\Interfaces\DatabaseInterface;
use Marve\Ela\MySql\Interfaces\DataInterface;
use Marve\Ela\MySql\Interfaces\ListInterface;
use Marve\Ela\MySql\Pagination;
use Marve\Ela\Validation\Validator;
use stdClass;

abstract class Model extends Pagination implements DatabaseInterface, ListInterface
{
    protected static $version = 0;
    public $table;    

    public $message;

    public $addRules;
    public $editRules;

    public $data;
    public function __construct(string $data_base = "", string $table = "")
    {
        if($data_base == "")
            $data_base = DotEnv::getDB();
        parent::__construct($table,$data_base);
        $this->table = $table;
        $this->addRules = [];
        $this->editRules = [];
    }
    
    /**
     * Summary of remove
     * @param string $id
     * @param string $column
     * @param int $user
     * @return int
     */
    public function remove(string $id, string $column, int $user = 0)
    {
         if(CurrentUser::isUser())
         {
            $id = $this->delete($this->table, $id, $column, $user);
            if($id == 0)
                $this->message = $this->conection->error;
            return $id;
         }
         else return 0;
    }
    
    /**
     * 
     * @param string $id
     * @param string $column
     * @param string $condicion
     * @return array|number|stdClass
     */
    public function get(string $id, string $column = '', string $condition = '0', string $orderby = '0')
    {
        if($id == "0")
        {
            $request = $this->query("*", $this->table,$condition, $orderby);
            if(count($request) > 0)
                return $request;
            else 
            {
                $this->message = $this->conection->error;
                return 0;
            }        
        }
        else 
        {
            $request = $this->query("*", $this->table, "$column = '$id'");
            if(count($request) > 0)
                return $request[0];
            else 
            {
                $this->message = $this->conection->error;
                return 0;
            }
        }
    }

    /**
     * Summary of getLimites
     * @param string $condicion
     * @param mixed $limit
     * @param mixed $orden
     * @return array|float|int
     */
    public function getLimites(string $condicion = "0", $limit = "0, 100", $orden = "0")
    {
        $request = $this->query("*", $this->table,$condicion, $orden, 0,$limit);
        if(count($request) > 0)
            return $request;
        else 
        {
            $this->message = $this->conection->error;
            return 0;
        }        
    }

    /**
     * Summary of isValid
     * @param mixed $newModel
     * @return bool
     */
    public function isValid($newModel = true)
    {
        //((validacion de campos))
        if($newModel)
        {
            $rules = $this->addRules;                    
        }
        else
        {
            $rules = $this->editRules;            
        }                            
        $valid = Validator::validate($this->data,$rules,$this);
        if($valid === true) 
            return $valid;
        else 
            $this->message = $valid;
        return false;           
    }   
    
    /**
     * 
     * @param stdClass $data
     * @param string $id
     * @param string $column
     * @param string $condicion
     * @param int $usuario
     * @return number
     */
    public function edit(stdClass $data, string $id, string $column = '', int $user = 0)
    {
         if(CurrentUser::isUser())
        {
            $this->data = $data;
            if($this->isValid(false) === true)
            {               
                foreach ($data as $key=>$validar) 
                {
                    $data->$key = $this->conection->real_escape_string($validar);
                }
                $id = $this->update($this->table, $data, $id, $column, $user);
                if($id == 0)
                    $this->message = $this->conection->error;
                return $id;
            }
            else return 0;
        }
        else return 0;
    }

    /**
     * Summary of updateDirect
     * @param mixed $data
     * @param mixed $id
     * @param mixed $column
     * @return float|int
     */
    public function updateDirect($data,$id, $column)
    {
        return $this->update($this->table, $data, $id, $column);
    }
    
    
    /**
     * 
     * @param stdClass $data
     * @return number
     */
    public function store(stdClass $data)
    {
         if(CurrentUser::isUser())
        {
            $this->data = $data;
            if($this->isValid() === true)
            {               
                foreach ($data as $key=>$validar) 
                {
                    $data->$key = $this->conection->real_escape_string($validar);
                }
                $id = $this->insert($this->table, $data);
                if($id == 0)
                    $this->message = $this->conection->error;
                return $id;
            }
             else return 0;
        }
        else return 0;
    }
    
    /**
     * 
     * @param string $column
     * @param string $valor
     * @return boolean
     */
    public function exists(string $column, string $valor)
    {
        $request = $this->query("*", $this->table, "$column = '$valor'");
        if($request !== 0 && count(value: $request) > 0)
            return true;
        else return false;
    }

    /**
     * Summary of existeMultiple
     * @param mixed $condicion
     * @return bool
     */
    public function existeMultiple($condicion)
    {
        $request = $this->query("*", $this->table, $condicion);
        if($request !== 0 && count($request) > 0)
            return true;
        else return false;
    }
    
    /**
     * Importar datos de una base de datos a otra
     * @param string $remote
     * @param string $update
     */
    public function import(string $remote, string $update = "")
    {
        $sql = "INSERT into $this->table 
            SELECT * from $remote".".$this->table;";
        
        if ($resultado = $this->conection->query("SHOW TABLES LIKE '$this->table'"))
        {
            if ($resultado->num_rows > 0 && strlen($sql) > 10) $this->conection->multi_query($sql);
        }        
        if ($resultado = $this->conection->query("SHOW TABLES LIKE '$this->table'"))
        {
            if ($resultado->num_rows > 0 && strlen($update) > 10) $this->conection->multi_query($update);
        }   
    }

    /**
     * Summary of createTable
     * @param \Marve\Ela\MySql\Interfaces\DataInterface $Data
     * @return void
     */
    protected function createTable(DataInterface $Data)
    {        
        $sql = $Data->sql();
        
        if ($resultado = $this->conection->query("SHOW TABLES LIKE '$this->table'"))
        {
            if ($resultado->num_rows == 0) $this->conection->multi_query($sql);
        }               
    }
        
    /**
     * Summary of updateTable
     * @param string $update
     * @return void
     */
    protected function updateTable(string $update = "")
    {        
         if($update !== "")
        if ($resultado = $this->conection->query("SHOW TABLES LIKE '$this->table'"))
        {
            if ($resultado->num_rows > 0 && strlen($update) > 10) $this->conection->multi_query($update);
        }   
    }

    /**
     * Summary of Select
     * @param string $fields
     * @param string $table
     * @param mixed $selected
     * @param mixed $condition
     * @param string $ordered
     * @param string $limit
     * @return string
     */
    public function Select(string $fields, string $table = "0", $selected = "0", $condition = "0", string $ordered = "0", string $limit = "0")
    {
        return $this->options($fields, $table,"id",$selected,$condition,$ordered, $limit) ;       
    }

    /**
     * Summary of Json
     * @param string $seleccionado
     * @param string $condicion
     * @param string $ordered
     * @param string $limit
     * @return string
     */
    public function Json(string $seleccionado,string $condicion = "0", string $ordered = "0", string $limit = "0")
    {

    }


}

