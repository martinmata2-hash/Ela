<?php
namespace Marve\Ela\MySql\Interfaces;

/**
 *
 * @author Martin
 *         Interface basica para las clases que interactuan con la base de datos
 *        
 */
interface ListInterface
{

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
    public function Select(string $fields, string $table = "0", $selected, $condition, string $ordered = "0", string $limit = "0");

    /**
     * Summary of Json
     * @param string $seleccionado
     * @param string $condicion
     * @param string $ordered
     * @param string $limit
     * @return string
     */
    public function Json(string $seleccionado,string $condicion = "0", string $ordered = "0", string $limit = "0");      
}