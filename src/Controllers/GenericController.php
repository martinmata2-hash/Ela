<?php
namespace Marve\Ela\Controllers;


use Marve\Ela\Core\Controller;
use Marve\Ela\Core\Generic;

class GenericController extends Controller
{
    
	
    private $Table;
    private $Key;
    /**
     */
    public function __construct($data_base, $table, $key) 
    {                
        $this->class = new Generic($data_base, $table); 
        $this->Table = $table;
        $this->Key = $key;
    }

	
	/**
	 * Registra data
	 * @param mixed $data
	 * @return number|string
	 */
	protected function store($data)
	{
	    $key = $this->Key;         		        
	    if(isset($data->$key) && $this->class->exists($key, $data->$key))
	    {
	        $this->request = $this->class->edit($data, $data->$key, $key);			
	    }
	    else
	    {
	        $this->request = $this->class->store($data);			
	    }	    
        return $this->request;
	}	

	/**
	 * Obtiene lista
	 * @param mixed $data
	 * @return string|number
	 */
    protected function list($data)
    {                
        $this->request = $this->class->list($data->name, $data->id, $data->selected, ($data->condition)??"0");        
        return $this->request;
    }
    
    protected function get($data)
    {        
        $this->request = $this->class->get($data->id, $data->campo);        
        return $this->request;
    }

}
