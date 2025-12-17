<?php
namespace Marve\Ela\Html\Form;

use Marve\Ela\Core\ArraytoObject;
use Marve\Ela\Html\Interfaces\FormInterface;

class GrupoInput extends Input implements FormInterface
{
    protected $inputs;
    protected $buttons;
    /**
     * Input en grupo
     * @param string $type input type     
     */
    public function __construct(string $type)
    {
        parent::__construct($type);       
        $this->buttons = array();                
        $this->inputs = array();
    }

    /**
     * 
     * @param string $link 
     * @param string $icono 
     * @param string $id 
     * @param string $onclik 
     * @return $this 
     */
    public function button($link, $icono, $id, $onclik = "", $color="primary", $titulo="")
    {
        $this->buttons[] = array("link" => $link, "icono" => $icono, "buttonId" => $id, "onclick"=>$onclik, "color"=>$color, "title"=>$titulo);        
        return $this;
    }    

    /**
     * Agrupa inputs
     * @param string $name 
     * @param string $id 
     * @param string $value 
     * @param string $class 
     * @param string $union 
     * @param string $data 
     * @return $this 
     */
    public function input($name, $id, $value , $class, $union="", $data="")
    {
        $this->inputs[] = array("name" => $name, "id" => $id, "value"=>$value, "class" => $class, 
            "union"=>$union, "data"=>$data);        
        return $this;
    }
    /**
     * Mostrar grupo
     * @return string
     */
    public function render()
    {             
        $textarea = "/>";
        $step = "";
        $input = "<input type='$this->type' class='form-control $this->clases'";   
        if($this->type == "number")
            $step = " step='$this->step' ";
        elseif($this->type == "readonly") 
            $step = " readonly ";
        elseif($this->type == "textarea")
        {
            $textarea = "></textarea>";
            $input = "<textarea class='form-control $this->clases' style='height: 8rem;' "; 
            $step = "";
        }
        else
            $step = "";
        $html = "        
        <div class='form-floating mb-3 input-group'>
            $input ".$this->setArgument("name",$this->name)." 
            ".$this->setArgument("id",$this->id)."
                $this->valid ".(($this->value)??"")." $step  ".$this->setArgument("data-id",$this->data)." $textarea                    
            <label for='$this->id'>$this->title</label>";
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
                
                $color = $value->color;
                
                $html .= "
                <span class='input-group-text'> 
                    <a class='btn btn-$color $box' id='$value->buttonId' href='$value->link' $onclick title='$value->title' > <i
                        class='fa $value->icono'></i>
                    </a>
                </span>";
            }
            foreach ($this->inputs as $key => $value) 
            {
                $value = ArraytoObject::convertir($value);
                $html .= "
                <span class='input-group-text'> 
                    $value->union
                </span>
                <input class='form-control $value->class' ".$this->setArgument("name",$value->name)." 
                ".$this->setArgument("id",$value->id)." 
                ".$this->setArgument("data-id",$value->data)." value='$value->value'/>
                ";
            }
            $html .= "</div>";          
        return $html;
    }

    /**
     * No esta implementado
     * @return string
     */
    public function renderSimple() 
    { 
        return "No esta implementado";
    }
}