<?php
namespace Marve\Ela\Html\Form;

use Marve\Ela\Core\ArraytoObject;
use Marve\Ela\Html\Interfaces\FormInterface;

class Input extends Element implements FormInterface
{
    /**
     * 
     * @var string
     */
    protected $value;
    /**
     * 
     * @var string
     */
    protected $step;
    protected $type;
    protected $auto;
    protected $data;
    /**
     * Summary of __construct
     * @param string $type Type
     * @param string $base_datos
     */
    public function __construct(string $type)
    {        
        $this->type = $type;
        $this->auto = false;                
    }

    /**
     * Datos principales del input
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
     * TIpo de validaciones para el input
     * @param string $type
     * @param bool $unique
     * @param string $model
     * @param bool $required
     * @param int $length
     * @return static
     */
    public function validation(string $type, bool $unique = false, string $model = '', bool $required = false, $length = 0) 
    {
        parent::validation($type,$unique,$model,$required, $length);
        return $this;
    }

    /**
     * Input hidden
     * @param string $name
     * @param string $id
     * @param string $value
     * @param string $class
     * @return static
     */
    public function hidden(string $name, string $id, string $value=" ", string $class=" ")
    {
        parent::hidden($name, $id, $value, $class);
        return $this;
    }

    /**
     * Cuando el Type es number
     * @param mixed $step
     * @return static
     */
    public function step($step)
    {
        $this->step = $step;
        return $this;
    }

    /**
     * Valor del input
     * @param string $value
     * @return static
     */
    public function value($value='')
    {
        $this->value = " value='$value' ";
        return $this;
    }

    public function autocomplete()
    {
        $this->auto = true;
        return $this;
    }
    /**
     * Usar campos data- para validacion o otros propositos
     * @param mixed $data
     * @return static
     */
    public function data($data)
    {
        $this->data = $data;
        return $this;
    }
    /**
     * Summary of render
     * @return string
     */
    public function render() 
    { 
        $html = "";
        if($this->type == "checkbox")
        {
            $class = "form-check-input form-floating mb-3";
            $classlabel = "class='form-check-label'";
            $div = "<div class='form-check'>";
            $closediv = "</div>";
            $br = "</br>";
            $step = "";
        }
        else
        {
            if($this->type == "number" || $this->type == "time")
                $step = " step='$this->step' ";
            elseif($this->type == "readonly")
                $step = "readonly";
            else $step = "";
            $div = "<div class='form-floating mb-3'>";
            $closediv = "</div>";
            $class = "form-control";
            $classlabel = "";
            $br = "";
        }
        if(isset($this->hiddenElement) && count($this->hiddenElement) > 0)
        {
            foreach ($this->hiddenElement as $k => $v) 
            {
                $v = ArraytoObject::convertir($v);
                $html .= "<input type='hidden' class='$v->class' 
                ".$this->setArgument("name",$v->name)." 
                ".$this->setArgument("id",$v->id)."                
                value='$v->value'/>";
            }
        }
        $autocomplete = ($this->auto)?"autocomplete='off' aria-autocomplete='none'":"";
        $html .= "
        $div
            $br
            <input type='$this->type' $step class='$class $this->clases' $autocomplete 
                ".$this->setArgument("data-id",$this->data)." ".$this->setArgument("name",$this->name)." 
                ".$this->setArgument("id",$this->id)."
                $this->valid ".(($this->value)??"")."/>                    
            <label $classlabel for='$this->id'>$this->title</label>
           $br $br
        $closediv";
        return $html;
    }    

    /**
     * Regresa el elemento sin label
     * @return string 
     */
    public function renderSimple()
    {
        $html = "";
        if($this->type == "checkbox")
        {
            $class = "form-check-input form-floating mb-3";            
            $step = "";
        }
        else
        {
            if($this->type == "number")
                $step = " step='$this->step' ";
            elseif($this->type == "readonly")
                $step = "readonly";
            else $step = "";
            
            $class = "form-control";
            
        }
        return "<input type='$this->type' $step class='$class $this->clases' ".$this->setArgument("data-id",$this->data)." 
            ".$this->setArgument("name",$this->name)." ".$this->setArgument("id",$this->id)." 
            
                $this->valid ".(($this->value)??"")."/>";
    }

}