<?php
namespace Marve\Ela\MySql;

use stdClass;

abstract class Query extends ConectionSingleton
{

    protected $error;
    public $data_base;

    function __construct(string $data_base)
    {
        $this->error = new Error();
        parent::__construct($data_base);
        if ($this->conection->select_db($data_base))
        {
            if ($resultado = $this->conection->query("SHOW TABLES LIKE 'eliminados'"))
            {
                if ($resultado->num_rows == 0) $this->conection->query($this->sqlTable());
            }
        }
        $this->data_base = $data_base;
    }
   
    /**
     * Summary of insert
     * @param string $table
     * @param stdClass $data
     * @param string $user
     * @return int
     */
    protected function insert(string $table, stdClass $data, string $user = "0"): int
    {
        if ($this->selectDB($this->data_base))
        {
            $queryelements = "";
            $query = "INSERT INTO " . $this->conection->real_escape_string($table) . " SET ";
            foreach ($data as $key => $value)
            {
                $key = $this->conection->real_escape_string($key);
                $value = $this->conection->real_escape_string($value);
                $queryelements .= "$key = '$value',";
            }
            $queryelements = rtrim($queryelements, ',');
            $query .= $queryelements;
            try
            {
                $result = $this->conection->query($query);
                if ($result !== FALSE)
                {
                    return $this->conection->insert_id;
                }
                else
                {
                    $this->error->report(get_class($this) . __METHOD__, $query . "  " . $this->conection->error);
                }
            }
            catch (\Exception $e)
            {
                $this->error->report(get_class($this) . __METHOD__, $query . "  " . $e->getMessage(), $user);
            }
        }
        else
        {
            return 0;
        }
        return 0;
    }

    /**
     *
     * @param string $table
     * @param stdClass $data
     * @param string $user
     * @return int
     */
    protected function replace(string $table, stdClass $data, string $user = "0"): int
    {
        if ($this->selectDB($this->data_base))
        {
            $queryelements = "";
            $query = "REPLACE INTO " . $this->conection->real_escape_string($table) . " SET ";
            foreach ($data as $key => $value)
            {
                $key = $this->conection->real_escape_string($key);
                $value = $this->conection->real_escape_string($value);
                $queryelements .= "$key = '$value',";
            }
            $queryelements = rtrim($queryelements, ',');
            $query .= $queryelements;
            try
            {
                $result = $this->conection->query($query);
                if ($result !== FALSE)
                {
                    return $this->conection->insert_id;
                }
                else
                {
                    $this->error->report(get_class($this) . __METHOD__, $query . "  " . $this->conection->error, $user);
                }
            }
            catch (\Exception $e)
            {
                $this->error->report(get_class($this) . __METHOD__, $query . "  " . $e->getMessage(), $user);
            }
        }
        else
        {
            return 0;
        }
        return 0;
    }

    /**
     *
     * @param string $table
     * @param stdClass $data
     * @param string $id
     * @param string $column
     * @param string $user
     * @return int
     */
    protected function update(string $table, stdClass $data, string $id, string $column, string $user = "0"):int
    {
        if ($this->selectDB($this->data_base))
        {
            $queryelements = "";
            $query = "Update " . $table . " SET ";
            foreach ($data as $key => $value)
            {               
                $key = $this->conection->real_escape_string($key);
                $value = $this->conection->real_escape_string($value);
                $queryelements .= "$key = '$value',";
            }
            $queryelements = rtrim($queryelements, ',');
            $query .= $queryelements;
            $query .= " WHERE " . $column . " = '$id' ";
            // $this->error->report("aqui", $query);
            try
            {
                $result = $this->conection->query($query);
                if ($result !== FALSE)
                {
                    if(is_numeric($id))
                        return (int)$id;
                    else return 1;
                }
                else
                {
                    $this->error->report(get_class($this) . __METHOD__, $query . "  " . $this->conection->error, $user);
                }
            }
            catch (\Exception $e)
            {
                $this->error->report(get_class($this) . __METHOD__, $query . "  " . $e->getMessage(), $user);
            }
        }
        else
        {
            return 0;
        }
        return 0;
    }

    /**
     *
     * @param string $table
     * @param string $id
     * @param string $column
     * @param string $user
     * @return int
     */
    protected function delete(string $table, string $id, string $column, $user = "0"): int
    {
        if ($this->selectDB($this->data_base))
        {
            try
            {
                $query = "DELETE FROM $table WHERE " . $column . "='$id' ";
                $result = $this->conection->query($query);
                if ($result !== FALSE)
                {
                    $data = new stdClass();
                    $data->EliTabla = $table;
                    $data->EliCampoID = $id;
                    $data->EliCampoNombre = $column; 
                    $this->insert("eliminados", $data);
                    return 1;
                }
                else
                {
                    $this->error->report(get_class($this) . __METHOD__, $query . "  " . $this->conection->error, $user);
                }
            }
            catch (\Exception $e)
            {
                $this->error->report(get_class($this) . __METHOD__, $query . "  " . $e->getMessage() . $user);
            }
        }
        else
        {
            return 0;
        }
        return 0;
    }

    /**
     *
     * @param string $table
     * @param string $condition
     * @param string $user
     * @return int
     */
    protected function deleteEspecial(string $table, string $condition, string $user = "0"): int
    {
        if ($this->selectDB($this->data_base))
        {
            try
            {
                $query = "DELETE FROM $table WHERE $condition";
                $result = $this->conection->query($query);
                if ($result !== FALSE)
                {
                    return 1;
                }
                else
                {
                    $this->error->report(get_class($this) . __METHOD__, $query . "  " . $this->conection->error, $user);
                }
            }
            catch (\Exception $e)
            {
                $this->error->report(get_class($this) . __METHOD__, $query . "  " . $e->getMessage() . $user);
            }
        }
        else
        {
            return 0;
        }
        return 0;
    }

    /**
     * 
     * @param string $columns
     * @param string $table
     * @param string $column_selected
     * @param string $column_value
     * @param string $where
     * @param string $orderby
     * @param string $limit
     * @return number|string
     */
    protected function options(string $columns, string $table, string $column_selected, string $column_value = "0", string $where = "0", string $orderby = "0", string $limit = "0")
    {
        $options = "";
        if ($this->selectDB($this->data_base))//estaConectado($this->data_base))
        {
            try
            {
                $query = "SELECT $columns FROM " . $table;
                if ($where != "0") $query .= " WHERE " . $where;
                if ($orderby != "0") $query .= " ORDER BY " . $orderby;
                if ($limit != 0) $query .= " Limit " . $limit;
                $result = $this->conection->query($query);
                //$this->error->report("optons", $query , 1);
                while ($fila = $result->fetch_object())
                {
                    $sltd = "";
                    if ($column_value == $fila->$column_selected) $sltd = " selected ";

                    $options .= "<option value='" . $fila->id . "' " . $sltd . ">" . $fila->name . "</option>";
                }

                return (strlen($options) > 0) ? $options : 0;
            }
            catch (\Exception $e)
            {
                $this->error->report(get_class($this) . __METHOD__, $query . "  " . $e->getMessage(), "admin");
            }
        }
        else
            return 0;
        return 0;
    }
    
    /**
     * 
     * @param string $columns
     * @param string $table
     * @param string $where
     * @param string $orderby
     * @param string $groupby
     * @param string $limit
     * @param string $user
     * @return array|number
     */
    protected function query(string $columns, string $table, string $where = "0", string $orderby = "0", string $groupby = "0", string $limit = "0", string $user = "0")
    {
        $data = array();
        if ($this->selectDB($this->data_base))
        {
            try
            {
                $query = "SELECT " . $columns . " FROM " .$table;
                if ($where != "0") $query .= " WHERE " . $where;
                if ($groupby != "0") $query .= " GROUP BY " .$groupby;
                if ($orderby != "0") $query .= " ORDER BY " . $orderby;
                if ($limit != "0") $query .= " Limit " . $limit;
                //$this->error->report("aqui", $query);
                $result = $this->conection->query($query);
                while ($fila = $result->fetch_object())
                {
                    $data[] = $fila;
                }
                return $data;
            }
            catch (\Exception $e)
            {
                $this->error->report(get_class($this) . __METHOD__, $query . "  " . $e->getMessage(), $user);
            }
        }
        else
            return 0;
        return 0;
    }

    /**
     * 
     * @param string $table
     * @param stdClass $data
     * @param string $where
     * @param string $user
     * @return int
     */
    protected function updateEspecial(string $table, stdClass $data, string $where, string $user = "0"): int
    {
        if ($this->selectDB($this->data_base))
        {
            $queryelements = "";
            $query = "Update " . $table . " SET ";
            foreach ($data as $key => $value)
            {
                $queryelements .= "$key = $value,";
            }
            $queryelements = rtrim($queryelements, ',');
            $query .= $queryelements;
            if ($where != "0") $query .= " WHERE " . $where;
            //$this->error->reporte ( get_class ( $this ) . __METHOD__, $query . " ", $user );
            try
            {
                $result = $this->conection->query($query);
                if ($result !== FALSE)
                {
                    return 1;
                }
                else
                {
                    $this->error->report(get_class($this) . __METHOD__, $query . "  " . $this->conection->error, $user);
                }
            }
            catch (\Exception $e)
            {
                $this->error->report(get_class($this) . __METHOD__, $query . "  " . $e->getMessage(), $user);
                
            }
        }
        else
            return 0;
        return 0;
    }
    
    /**
     * 
     * @param string $table
     * @param string $id
     * @param string $condition
     * @return array|number
     */
    protected function lastRecord(string $table, string $id, string $condition = "0")
    {
        $data = array();
        if ($this->selectDB($this->data_base))
        {
            try
            {
                $query = "SELECT MAX($id) as ultimo FROM $table";
                if($condition != 0)
                    $query .= " where $condition";
                //$this->error->reporte("aqui", $query);
                $result = $this->conection->query($query);
                while ($fila = $result->fetch_object())
                {
                    $data[] = $fila;
                }
                return $data;
            }
            catch (\Exception $e)
            {
                $this->error->report(get_class($this) . __METHOD__, $query . "  " . $e->getMessage());
            }
        }
        else
            return 0;
        return 0;
    }
    
    /**
     *
     * @return string Estructura para base de datos mysql
     */
    private function sqlTable()
    {
        $mysql = "
            
			CREATE TABLE IF NOT EXISTS `eliminados` (
			  `EliID` int(11) NOT NULL AUTO_INCREMENT,
			  `EliTabla` varchar(40) NOT NULL,
			  `EliCampoID` int(11) NOT NULL ,
			  `EliCampoNombre` varchar(40) NOT NULL,
			  `updated` tinyint(1) NOT NULL,
			  PRIMARY KEY (`EliID`)
			) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
        return $mysql;
    }
}

