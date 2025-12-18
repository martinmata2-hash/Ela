<?php
namespace App\Controllers;
use Marve\Ela\Controllers\ModelController;
use Marve\Ela\Core\CurrentUser;
use Marve\Ela\Core\Domicilios;

class Domicilio extends ModelController
{
    /**
     */
    public function __construct() 
    {                
      $this->class = new Domicilios(CurrentUser::getDb());
      parent::__construct("DomID");        
    }          
    
    protected function cp($data)
    {
        $this->request = $this->class->cp($data->cp, $data->pais);
        return $this->request;
    }

    protected function paises()
    {
        $this->request = $this->class->paises();
        return $this->request;
    }

    protected function estados($data)
    {
        $this->request = $this->class->estados($data->pais);
        return $this->request;
    }

    protected function municipios($data)
    {
        $this->request = $this->class->municipios($data->estado, $data->municipio??0);
        return $this->request;
    }

    protected function colonia($data)
    {
        $this->request = $this->class->colonia($data->estado, $data->municipio);
        return $this->request;
    }

    protected function localidad($data)
    {
        $this->request = $this->class->localidad($data->cp);
        return $this->request;
    }

    protected function coloniaCp($data)
    {
        $this->request = $this->class->coloniaCp($data->codigo, $data->nombre);
        return $this->request;
    }
}
