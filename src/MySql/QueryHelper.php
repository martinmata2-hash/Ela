<?php

namespace Marve\Ela\MySql;
use Marve\Ela\MySql\Query;

/**
 * 
 * $OBject->Init("camp1,camp2, campo3 as campo")
 * ->Table("tabla1 inner join tabla2 on id1 = id2")
 * ->Condition("camp1 = 3) //where
 * ->Order("camp2") //Order by
 * ->Limit("3,4") // Ofser, Limit
 * ->render()
 * $Object->Render() Usara los valores default.
 * 
 */
class QueryHelper extends Query
{

    /**
     * campos a buscar en query
     * @var string
     */
    protected $columns;
    /**
     * tablas a usar en query
     * @var string
     */
    protected $table;
    /**
     * COnsidion (where) en query
     * @var string
     */
    protected $condition;
    /**
     * Orden de los resultado
     * @var string
     */
    protected $order;
    /**
     * Agrupacion de datos
     * @var mixed
     */
    protected $group;
    /**
     * Limite en busqueda 
     * @var mixed
     */
    protected $limit;

    public function __construct($table, $data_base)
    {
        parent::__construct($data_base);
        $this->columns = "*";
        $this->table = $table;
        $this->condition = "0";
        $this->order = "0";
        $this->group = "0";
        $this->limit = "0";
    }
    /**
     * Campos a buscar 
     * @param string $columns 
     * @return $this 
     */
    public function Init($columns = "*")
    {
        $this->columns = $columns;        
        return $this;
    }

    /**
     * Selecionar una o multiple tablas unidas a un join
     * @param string $table 
     * @return $this 
     */
    public function Table($table)
    {
        $this->table = $table;
        return $this;
    }

    /**
     * Considion de la busqueda
     * @param string $condition 
     * @return $this 
     */
    public function Condition($condition)
    {
        $this->condition = $condition;
        return $this;
    }

    /**
     * Campo a ordenar asc|desc
     * @param string $order 
     * @return $this 
     */
    public function Order($order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * Campos a Agrupar 
     * @param mixed $group 
     * @return $this 
     */
    public function Group($group)
    {
        $this->group = $group;
        return $this;
    }

    /**
     * Limitar el resultado a cuantos 
     * @param mixed $limit 
     * @return $this 
     */
    public function Limit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * Cuandos primeros datos requieres
     * @param string $column
     * @param string $cuantos 
     * @return $this 
     */
    public function First($column, $cuantos = "1")
    {
        $this->order = "$column asc";
        $this->limit = $cuantos; 
        return $this;
    }

    /**
     * Cuantos ultimos datos requieres
     * @param string $column
     * @param string $cuantos 
     * @return $this 
     */
    public function Last($column, $cuantos = "1")
    {
        $this->order = "$column desc";
        $this->limit = $cuantos; 
        return $this;
    }

    /**
     * Iniar del record $inico y contar $cuantos
     * @param int $inicio 
     * @param int $cuantos 
     * @return $this 
     */
    public function Range(int $inicio, int $cuantos)
    {
        $this->limit("$inicio, $cuantos");
        return $this;
    }

    /**
     * Regresar todos los datos
     * @param string $columns 
     * @return $this 
     */
    public function All($columns = "*")
    {
        $this->columns = $columns;
        return $this;
    }
    /**
     * ejecutar el query
     * @return array|int 
     */
    public function Render()
    {
        return $this->query($this->columns,$this->table, $this->condition, $this->order, $this->group, $this->limit);
    }




}