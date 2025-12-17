<?php
namespace Marve\Ela\Html\Form;


use Marve\Ela\Core\ArraytoObject;
use Marve\Ela\Core\Generic;
use Marve\Ela\Core\Model;
use Marve\Ela\Html\Interfaces\FormInterface;
use Marve\Ela\MySql\Interfaces\ListInterface;
use Marve\Ela\MySql\QueryHelper;

class Select extends Element implements FormInterface
{
    protected $Multiple;
    public function __construct()
    {                  
        parent::__construct();       
        $this->Multiple = false;
    }


    /**
     * Summary of opcions
     * @param array $array
     * @param mixed $selected
     * @return static
     */
    public function options(array $array = [], $selected = 0)
    {        
        if($array == null)
            return $this;
        else
        {
            foreach ($array as $key => $value) 
            {
                $selectedText = "";
                if($key == $selected)
                    $selectedText = " selected";
                $this->list .= "<option value='$key' $selectedText >$value</option>";
            }   
            return $this;
        }

    } 

    /**
     * Summary of hidden
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
     * Summary of campos
     * @param string $name
     * @param string $id
     * @param string $titulo
     * @param string $clases
     * @return static
     */
    public function fields(string $name, string $id = '', string $title = '', string $clases = '')
    {
        parent::fields($name,$id,$title,$clases);        
        return $this;
    }

    /**
     * Summary of fromBD class Generic mas be declared on use Generic
     * @param \Marve\Ela\MySql\Interfaces\ListInterface $model
     * @param mixed $table
     * @param string $name
     * @param string $id
     * @param string $selected
     * @param string $condicion
     * @param string $ordered
     * @param string $limit
     * @return static
     */
    public function fromDB($data_base,$table, string $name, string $id, string $selected = "0", string $condition = "0", string $ordered = "0")
    {                

        $this->list = (new Generic($data_base,$table))
            ->list($name, $id, $selected, $condition, $ordered);        
        return $this;
    }

    public function value($valor='')
    {
        //No aplica
    }

    /**
     * Summary of validation
     * @param string $type
     * @param bool $unique
     * @param string $model
     * @param bool $required
     * @param int $length
     * @return static
     */
    public function validation(string $type, bool $unique = false, string $model = '', bool $required = false, int $length = 0)
    {
        parent::validation($type,$unique,$model,$required,$length);
        return $this;
    }
   
    public function multiple()
    {
        $this->Multiple = true;
        return $this;
    }
    public function render()
    {
        if($this->Multiple)
            $multiple = " multiple size='4' aria-label='multiple' style='height:150px !important'";
        else
            $multiple = "";
        $html = "
        <div class='form-floating mb-3'>";
            if(count($this->hiddenElement)> 0)
                foreach ($this->hiddenElement as $k => $v) 
                {
                    $v = ArraytoObject::convertir($v);
                    $html .= "<input type='hidden' class='$v->class' ".$this->setArgument("name",$v->name)." 
                    ".$this->setArgument("id",$v->id)." value='$v->value'/>";
                }
            $html .="
            <select class='form-select $this->clases' ".$this->setArgument("name",$this->name)." 
            ".$this->setArgument("id",$this->id)."                 
                $this->valid >
                <option value='0'>Selecciona</option>
                    $this->list
            </select>
            <label for='$this->id'>$this->title</label>
        </div>";
        return $html;
    }

    public function renderSimple() 
    { 
        return "No esta implementado";
    }
}