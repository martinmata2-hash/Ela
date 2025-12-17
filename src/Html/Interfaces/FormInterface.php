<?php
namespace Marve\Ela\Html\Interfaces;
use stdClass;

interface FormInterface
{
     /**
     * Valores de los campos
     * @param string $name <b> name='Nombre'
     * @param string $id  <b> id='id'
     * @param string $title  label
     * @param string $clases  clases adicionales
     * @return mixed 
     */

     public function fields(string $name,string $id ="", string $title = "",string $clases= "");
    
     /**
      * Valor asignado al elemento
      * @param string $valor <b> value='valor'
      * @return mixed 
      */
     public function value($value='');
     /**
      * Regresa el elemento formado
      * @return string 
      */
     public function render();

      /**
      * Regresa elemento sin div, solo el elmento
      * @return string 
      */
      public function renderSimple();
}