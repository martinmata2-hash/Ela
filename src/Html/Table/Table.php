<?php
namespace Marve\Ela\Html\Table;

use Marve\Ela\Html\Interfaces\FormInterface;

class Table extends Tr implements FormInterface
{
     /**
     * 
     * @var bool
     */
    protected $thead;
    /**
     * 
     * @var bool
     */
    protected $tbody;

    /**
     * Summary of title
     * @var string
     */
    protected $title;
    /**
     * Summary of name
     * @var string
     */
    protected $name;

    protected $search;


    public function __construct()
    {        
        $this->thead = false;
        $this->tbody = false;        
    }

    public function fields(string $name, string $id = "", string $title = "", string $clases = "") { }
    

    public function value($valor = '') { }


    /**
     * Inicia construccion de Tabla
     * @param string $name 
     * @param string $id 
     * @param string $title 
     * @param string $clases 
     * @param bool $grid
     * @return $this 
     */
    public function inicio(string $name, string $id = '', string $title = '', string $clases = '', $grid = false, $search = false)
    {
        $this->search = $search;
        $this->gridcss = $grid;
        $this->title = $title;
        $this->name = $name;
        if($this->gridcss)
            $css = "ui-jqgrid-htable table table-hover";
        else $css = "table";
        $this->html = "<table ".$this->setArgument("id",$id)." class='$css $clases'>";        
        return $this;
    }

    /**
     * thead
     * @param string $id 
     * @return $this 
     */
    public function header(string $id = "")
    {
        $this->html .= "<thead ".$this->setArgument("id",$id)." >";
        $this->thead = true;
        return $this;
    }

    public function htr(string $id = "")
    {
        if($this->thead)
        {
            parent::htr($id);            
        }        
        return $this;
    }

    /**
     * tbody
     * @param string $id 
     * @return $this 
     */
    public function body(string $id="")
    {
        if($this->thead)
        {
            if($this->headerTr)
            {
                $this->headerTr = false;
                $this->html .="</tr>";
            }
            $this->html .= "</thead>";
            $this->thead = false;
        }
        $this->tbody = true;
        $this->html .= "<tbody ".$this->setArgument("id",$id)." >";
        return $this;
    }

    /**
     * tr dentro de tbody
     * @param string $txt 
     * @param string $id 
     * @return $this 
     */
    public function tr(string $id = "", string $clase = "")
    {
        if(!$this->thead && $this->tbody)
        {
            parent::tr($id, $clase);
        }        
        return $this;
    }

    /**
     * Summary of th
     * @param mixed $width
     * @param string $txt
     * @param string $id
     * @param int $span
     * @param FormInterface|null $elemento
     * @return static
     */
    public function th($width, string $txt = "", string $id = "", int $span = 1, ?FormInterface $elemento = null, $class = "")
    {
        if($this->thead)
        {
            parent::th($width,$txt,$id,$span,$elemento);            
        }
        return $this;
    }

    /**
     * Summary of addBody
     * @param mixed $html
     * @return static
     */
    public function addBody($html)
    {
        if(!$this->thead && $this->tbody)
        {
            $this->html .= $html;
        }
        return $this;
    }

    /**
     * Regresa la Tabla terminada
     * @return string 
     */
    public function render($grid = false) 
    { 
        if($this->tbody)
        {
            if($this->bodyTr)
                $this->html .= "</tr></tbody>";
            
            $this->html .= "</table>";
        }
        if($this->gridcss)
                return "
                <div class='ui-jqgrid ui-widget ui-widget-content ui-corner-all ui-jqgrid-resp'>
                <div class='ui-jqgrid-titlebar ui-jqgrid-caption ui-widget-header ui-corner-top ui-helper-clearfix table-responsive'>
                <span class='ui-jqgrid-title'><h6>$this->title</h6></span>  <span class='float-end'><input placeholder='Buscar por nombre' type='text' class='form-control'></span></div>$this->html </div>
        ";
        elseif($this->search)         
            return "<div class='table-responsive'><span class='ui-jqgrid-title'><h6>$this->title</h6></span>  <span class='float-end'><input placeholder='Buscar por nombre' type='text' class='form-control'></span>$this->html </div>";        
        else 
            return "<div class='table-responsive'><span class='ui-jqgrid-title'><h6>$this->title</h6></span> $this->html </div>";        
        
    }
}