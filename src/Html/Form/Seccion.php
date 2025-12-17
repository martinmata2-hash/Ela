<?php
namespace Marve\Ela\Html\Form;

use Marve\Ela\Html\Interfaces\FormInterface;

/**
 * Diviciones en forma
 */
class Seccion extends Element implements FormInterface
{
    /**
     * 
     * @var string
     */
    protected $valor;
       
    /**
     * Agrega diviciones a la forma
     * @param string $base_datos
     */
    public function __construct()
    {
        parent::__construct();       
        $this->valor = "4";
    }

    /**
     * Summary of fields
     * @param string $name
     * @param string $id
     * @param string $title
     * @param string $clases
     * @return static
     */
    public function fields(string $name, string $id = '', string $title = '', string $clases = '')
    {            
        parent::fields($name,$id,$title,$clases);  
        return $this;
    }

    /**
     * Summary of value
     * @param mixed $value
     * @return static
     */
    public function value($value='')
    {                
        $this->valor = $value;
        return $this;
    }

    public function render() 
    { 
        if($this->name == "inicio")
            return "<div class='col-md-$this->valor $this->clases' 
                ".$this->setArgument("id",$this->id)." >
                ".(($this->title !== "")?"<h3>$this->title</h3>":"")." ";
        else return "</div>";
    }
    
    
    public function renderSimple() 
    { 
        return "No esta implementado";
    }

}