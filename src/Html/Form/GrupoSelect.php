<?php
namespace Marve\Ela\Html\Form;

use Marve\Ela\Core\ArraytoObject;

class GrupoSelect extends Select
{
    protected $icono;
    protected $link;

    protected $buttonId;

    protected $buttons;
    protected $inputs;
    /**
     * Summary of __construct
     * @param string $base_datos
     */
    public function __construct()
    {
        parent::__construct();       
        $this->buttons = array();                
        $this->inputs = array();
    }

    /**
     * Agrupa boton
     * @param string $link 
     * @param string $icono 
     * @param string $id 
     * @param string $onlcik 
     * @return $this 
     */
    public function button(string $link, string $icono, string $id, string $onlcik = "")
    {
        $this->buttons[] = array("link" => $link, "icono" => $icono, "buttonId" => $id, "onclick"=>$onlcik);        
        return $this;
    }

    /**
     * Summary of input
     * @param string $name
     * @param string $id
     * @param string $value
     * @param string $class
     * @return static
     */
    public function input(string $name, string $id, string $value, string $class)
    {
        $this->inputs[] = array("name"=>$name, "id"=>$id, "value"=>$value, "class"=>$class);
        return $this;
    }
    /**
     * Summary of render
     * @return string
     */
    public function render()
    {                
        $html = "        
        <div class='input-group form-floating mb-3'>
            <select class='form-select $this->clases' ".$this->setArgument("name",$this->name)." 
            ".$this->setArgument("id",$this->id)." $this->valid >
                <option value='0'>Selecciona</option>
                    $this->list
            </select>
            <label for='$this->id'>$this->title</label>";        
            foreach ($this->inputs as $key => $value) 
            {
                $value = ArraytoObject::convertir($value);
                
                $html .= "
                <input class='form-control' id='$value->id' name='$value->name' class='$value->class' value='$value->value' />"; 
            }
            foreach ($this->buttons as $key => $value) 
            {
                $value = ArraytoObject::convertir($value);
                if($value->onclick != "")
                {
                    $onclick = "onclick='$value->onclick' ";
                    $box = "";
                }
                else 
                {
                    $onclick = "";
                    $box = "box";
                }
                $html .= "
                <span class='input-group-text'> 
                    <a class='btn btn-primary $box' id='$value->buttonId' href='$value->link' 
                        $onclick > <i
                        class='fa $value->icono'></i>
                    </a>
                </span>";
            }
            $html .= "</div>";          
        return $html;
    }

    public function renderSimple() 
    { 
        return "No esta implementado";
    }
}