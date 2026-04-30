<?php
namespace Marve\Ela\Core;

use Marve\Ela\Core\Model;

class Generic extends Model
{
   
    
    public function __construct( $data_base, $tabla)
    {           
        $this->data_base = $data_base;        
        parent::__construct($data_base, $tabla);                      
    }           
    
    
    /**
     * Summary of lista
     * Genera una lista de opciones para select de 100 elementos max
     * @param mixed $name
     * @param mixed $id
     * @param mixed $selected
     * @param mixed $condition
     * @param mixed $ordered
     * @param mixed $limit
     * @return float|int|string
     */
    public function list($name, $id, $selected, $condition = "0", $ordered = "0", $limit = "100")
    {
        return $this->options("$id as id, $name as name" , $this->table, "id", $selected, $condition, $ordered, $limit);
    }

}
