<?php
namespace Marve\Ela\Html;


class ElementValidation
{
    /**
     * 
     * @var string
     */
    protected $clases;
    /**
     * 
     * @var string
     */
    protected $validationType;
    /**
     * 
     * @var string
     */
    protected $validationUnique;
    /**
     * 
     * @var string
     */
    protected $validationModel;
    /**
     * 
     * @var string
     */
    protected $validationRquired;
    /**
     * 
     * @var int
     */
    protected $validationLength;
    /**
     * 
     * @var string
     */
    protected $valid;
    /**
     * Render las validaciones
     * @return void 
     */
    protected function setValidations()
    {        
        $this->valid ="";
        if( strlen($this->validationType) > 2)
            $this->valid .= " data-type='$this->validationType' ";
        if($this->validationUnique)
            $this->valid .= " data-unico='true' ";
        if(strlen($this->validationModel) > 2)
            $this->valid .= " data-validar='$this->validationModel' ";
        if($this->validationLength > 0)
            $this->valid .= " data-length='$this->validationLength' ";
        if($this->validationRquired)
            $this->valid .= " required ";
        $this->clases .= " border-danger valida ";        
    } 

    /**
     * Evida incluir nombres o ids vacios, valida los campos antes de agregarlos a la forma
     * @param mixed $nombre 
     * @param mixed $value 
     * @return string 
     */
    protected function setArgument($nombre, $value = null)
    {
        if(isset($value) && ($value != "") )
            return "$nombre = '$value'";
        else return "";
    }
}