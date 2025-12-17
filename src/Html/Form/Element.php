<?php
namespace Marve\Ela\Html\Form;

use Marve\Ela\Html\ElementValidation;


class Element extends ElementValidation
{
    /**
     * 
     * @var string
     */
    protected $list;
    /**
     * 
     * @var string
     */
    protected $name;
    /**
     * 
     * @var string
     */
    protected $id;    
    /**
     * 
     * @var string
     */
    protected $data;
    /**
     * 
     * @var string
     */
    protected $title;
    
    protected $hiddenElement;
    
   
    public function __construct()
    {                             
        $this->hiddenElement = array();
    }

    /**
     * Valores de los campos
     * @param string $name <b> name='Nombre'
     * @param string $id  <b> id='id'
     * @param string $title  label
     * @param string $clases  clases adicionales
     * @return mixed 
     */
    public function fields(string $name, string $id = "", string $title = "", string $clases = "") 
    { 
        $this->name = $name;
        $this->id = $id;
        $this->clases = $clases;        
        $this->title = $title;       
    }

    /**
     * validacion del elemento
     * @param string $type <b> Validar Nombre, Codigo, Email, Fecha, Telefono, Length etc
     * @param bool $unique  <b>El valor es unico?
     * @param string $model  <b> Que Modelo (Clases) se encarga de la validacion
     * @param bool $required  <b> El Campos es requerido?
     * @param int $length  <b> Si la validacion es Length cuantos caracteres
     * @return mixed 
     */
    public function validation(string $type, bool $unique = false, string $model = "", 
        bool $required = false, int $length = 0)
    {
        $this->validationType = $type;
        $this->validationUnique = $unique;
        $this->validationModel = $model;
        $this->validationRquired = $required;
        $this->validationLength = $length;
        $this->setValidations();
    }

    /**
     * Agregar input type hidden
     * @param string $name 
     * @param string $id 
     * @param string $value 
     * @param string $class 
     * @return static 
     */
    public function hidden(string $name, string $id, string $value=" " , string $class=" " )
    {
        $this->hiddenElement[] = array("name"=> $name,"id"=>$id, "value"=>$value,"class"=>$class);        
        return $this;
    }

}