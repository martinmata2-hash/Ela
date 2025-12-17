<?php

namespace Marve\Ela\Html\Form;

use Marve\Ela\Core\Session;
use Marve\Ela\Html\Form\Seccion;
use Marve\Ela\Html\Interfaces\FormInterface;
use Marve\Ela\Html\Table\Table;

class Form extends Element implements FormInterface
{

    /**
     * 
     * @var FormInterface[];
     */
    protected $Elements;
    /**
     * 
     * @var int
     */
    protected $columns;
    /**
     * 
     * @var bool
     */
    protected $vertical;
    /**
     * 
     * @var string
     */
    protected $metod;
    /**
     * 
     * @var string
     */
    protected $action;
    /**
     * 
     * @var string
     */
    protected $target;

    /**
     * 
     * @var bool
     */
    protected $continue;
    
    protected $submit;

    protected $CSRF;

    protected $enctype;

    protected $submitButton;

    protected $reCaptcha;
    
    /**
     * Summary of __construct
     * @param int $columns
     * @param bool $vertical
     * @param bool $continue
     * @param string $base_datos
     */
    public function __construct( int $columns,bool $vertical = false, bool $continue = false)
    {
        parent::__construct();                       
        $this->columns = $columns;
        $this->vertical = $vertical;
        $this->action = "";
        $this->target = "_self";
        $this->metod = "get";
        $this->continue = $continue;
        $this->submit = true;
        $this->enctype = false;
        $this->submitButton = "Archivar";
        $this->CSRF = true;
        $this->reCaptcha = "";
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
     * No es usado de momento
     * @param string $valor <b> default es get 
     * @return mixed 
     */
    public function value($valor='')
    {
        //no aplica 
    }


    /**
     * Forma con archivos
     * @return static
     */
    public function encType()
    {
        $this->enctype = true;
        return $this;
    }
    
    /**
     * No incluir boton de submit y
     * @param bool $CSRF incluir campo CDRF para verificacion
     * @return static
     */
    public function noSubmit(bool $CSRF = true) 
    {
        $this->submit = false;
        if($CSRF == false)
            $this->CSRF = false;
        return $this;
    }

    /**
     * Que el boton tenga un titulo distinto a archivar
     * @param mixed $label default es archivar
     * @return static
     */
    public function sumitButtonLabel($label)
    {
        $this->submitButton = $label;
        return $this;
    }
    /**
     * Quien procesa la peticion y donde se muestra
     * @param string $action <b> /Pagina 
     * @param string $target <b> default _self
     * @param string $metod <b> method default get
     * @return $this 
     */
    public function action($action, $target = "_self", $metod = "get")
    {
        $this->action = $action;
        $this->target = $target;
        $this->metod = $metod;
        return $this;
    }

    public function captcha($sitekey)
    {
        $this->reCaptcha = $sitekey;
    }
    /**
     * Muestra la forma y sus elementos
     * @return string 
     */
    public function render() 
    { 
        $divicion = $this->columns;
        $columns = 12/intval($divicion);
        if($this->vertical)
        {           
            $verticales = intval(round(count($this->Elements)/$divicion));
        }
        else $verticales = 1;
        if($this->enctype)
            $enctype = " enctype = 'multipart/form-data'";
        else $enctype = "";
        $html = "
        <h3>$this->title</h3>
        <form id='$this->id' $enctype class='$this->clases' method='$this->metod' action='$this->action', target='$this->target' 
        aria-autocomplete='none' autocomplete='off' >
            <div class='row gx-3 justify-content-center $this->clases'>";      
         if($this->CSRF) $html .=   "<input id='CSRF' type='hidden' value='".Session::getCsrf()."'/>";

        $counter = $verticales;
        $elementos = 0;
        foreach ($this->Elements as $key => $value) 
        {                        
            if($counter % $verticales == 0 && $this->continue == false)
            {        
                if(!$value instanceof Seccion && !$value instanceof Table)
                    $html .= "<div class='col-md-$columns'>";
            }
            $counter++;
            $elementos++;
            //if($value instanceof Seccion)
                //$value->value($columns);
            $html .= $value->render();
            if($counter % $verticales == 0  && $this->continue == false)    
            {          
                if(!$value instanceof Seccion && !$value instanceof Table)  
                    $html .= "</div>";            
            }
            elseif($elementos == count($this->Elements) && $counter %  $verticales != 0)
                $html .= "</div>";            
        }
        if($this->submit)
        {
            $captcha = "";            
            if(strlen($this->reCaptcha) > 10)
            {                                
                $captcha = "<div class='g-recaptcha justify-content-center' data-sitekey = '$this->reCaptcha'></div>";
            }
            $html .= "
            <div class='col-md-12'>
                <!-- Submit Button-->
                
                <div class='col-md-4 mx-auto d-block col-auto button-group text-center'>         
                    $captcha               
                    <button class='btn btn-primary archivar ' id='submit$this->name' type='submit'>$this->submitButton</button>
                    <!-- <button class='btn btn-danger' id='reset$this->name' type='reset'>Reset</button> -->
                </div>    			
            </div>";
        }
        $html .= "</div></form>";
        return $html;
    }
    
    /**
     * Agregar los elementos a la forma
     * @param FormInterface $elemento
     * @return void
     */
    public function add(FormInterface $elemento)
    {
        $this->Elements[] = $elemento;
    }

    /**
     * Mostrar sin css
     * @return string
     */
    public function renderSimple() 
    { 
        return "No esta implementado";
    }

}
