<?php
namespace Marve\Ela\Html\Form;

use Marve\Ela\Html\Interfaces\FormInterface;

class TextArea extends Element implements FormInterface
{
    /**
     * 
     * @var string
     */
    protected $textValue;
    

    public function __construct()
    {
        parent::__construct();                     
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
     * 
     * @param string $tipo 
     * @param bool $unico 
     * @param string $modelo 
     * @param bool $requerido 
     * @param int $length 
     * @return mixed 
     */
    
    public function validation(string $type, bool $unique = false, string $model = '', bool $required = false, int $length = 0)
    {
        parent::validation($type,$unique,$model,$required, $length);
        return $this;
    }

    /**
     * Summary of value
     * @param mixed $textValue
     * @return static
     */
    public function value($textValue ='')
    {
        $this->textValue = "$textValue";
        return $this;
    }

    public function render() 
    {                
        return "
        <div class='form-floating mb-3'>        
            <textarea  style='width: 100%; height: 8rem;'  class='form-control $this->clases' name='$this->name' id='$this->id'
                $this->valid >".(($this->textValue)??"")."</textarea>                                    
            <label for='$this->id'>$this->title</label>           
        </div>";
    }    

    public function renderSimple() 
    { 
        return "            
            <textarea  style='width: 100%;'  class='form-control $this->clases' name='$this->name' id='$this->id'
                $this->valid >".(($this->textValue)??"")."</textarea>";
    }
}