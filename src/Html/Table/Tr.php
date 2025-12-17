<?php

namespace Marve\Ela\Html\Table;

use Marve\Ela\Html\ElementValidation;
use Marve\Ela\Html\Interfaces\FormInterface;

class Tr extends ElementValidation
{
    /**
     * 
     * @var bool
     */    
    protected $headerTr;    
    /**
     * 
     * @var bool
     */
    protected $bodyTr;

    /**
     * 
     * @var string
     */
    protected $html;

    /**
     * 
     * @var bool
     */
    protected $gridcss;
    public function __construct()
    {        
        $this->headerTr = false;
        $this->bodyTr = false;   
        $this->gridcss = false;
    }

    /**
     * tr tag en theade
     * @param string $id 
     * @return $this 
     */
    public function htr(string $id = "")
    {
       $this->headerTr = true;
        if($this->gridcss)
            $css = "class='ui-jqgrid-labels'";
        else $css = "";
        $this->html .= "<tr $css ".$this->setArgument("id",$id)." >";                
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
        if($this->headerTr)
        {
            $elementos = "";
            if($elemento != null)
                $elementos = $elemento->renderSimple();
            if($this->gridcss)
                $css = "class='ui-state-default ui-th-column ui-th-ltr $class'";
            else 
                $css = "class='$class'";
            $this->html .= "<th $css width='$width' ".$this->setArgument("id",$id). 
            " ".$this->setArgument("span", $span).">"
             ." $txt $elementos </th>";
        }
        return $this;
    }

    /**
     * tr dentro de tbody
     * @param string $txt 
     * @param string $id 
     * @return $this 
     */
    public function tr(string $id = "", string $class="") 
    {        
        if($this->bodyTr)
        {
            $this->html .= "</tr><tr ".$this->setArgument("id",$id)." ".$this->setArgument("class",$class)." >";
        }
        else
        {
            $this->bodyTr = true;
            $this->html .= "<tr ".$this->setArgument("id",$id)." ".$this->setArgument("class",$class).">";
        }                
        return $this;
    }

    /**
     * Summary of td
     * @param string $txt
     * @param string $id
     * @param int $span
     * @param FormInterface|null $elemento
     * @return static
     */
    public function td(string $txt = "", string $id = "", int $span= 1, FormInterface $elemento = null, $class = "")
    {
        if($this->bodyTr)
        {
            $hide = "";
            if($span == 0)
            {
                $span = 1;
                $hide = " style='display:none;' ";                
            }            
            $elementos = "";
            if($elemento !== null)
                $elementos = $elemento->renderSimple();
            $this->html .= "<td ".$this->setArgument("id",$id). 
            " ".$this->setArgument("colspan", $span)." $hide ".$this->setArgument("class", $class).">"
            ." $txt $elementos </td>";
        }        
        return $this;
    }

    public function renderSimple()
    {
        if($this->bodyTr)
        {
            $this->html .= "</tr>";
        }
        return $this->html;
    }

}