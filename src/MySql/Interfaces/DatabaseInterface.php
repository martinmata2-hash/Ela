<?php
namespace Marve\Ela\MySql\Interfaces;
use stdClass;

interface DatabaseInterface
{
    /**
     * Agregar data
     * @param stdClass $data
     */
    public function store(stdClass $data);
    /**
     * Obtener data
     * @param string $id
     * @param string $column
     * @param string $condition
     */
    public function get(string $id,string $column = "", string $condition = "", string $orderby = "0");
    /**
     * Editar column
     * @param string $id
     * @param string $column
     * @param string $condition
     */
    public function edit(stdClass $data, string $id, string $column = "", int $user = 0);
    /**
     * Borrar column
     * @param string $id
     * @param string $column
     * @param string $condition
     */
    public function remove(string $id, string $column, int $user = 0);
    
    /**
     * comprueba que exista
     */
    public function exists(string $column, string $value);
}

