<?php
namespace Marve\Ela\Interfaces;

interface GridInterface
{
    /**
     * Devuelve los campos del datagrid
     * @param array $arguments
     * @return array
     */
    public function grid($arguments = null);
    
    /**
     * Devuelve la forma a usar para agregar datos
     * @return string
     */
    public function form($arguments = null);
    
}