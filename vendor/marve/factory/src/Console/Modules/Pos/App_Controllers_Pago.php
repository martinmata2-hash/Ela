<?php
namespace App\Controllers;
use App\Models\Pos\Ventas;
use Marve\Ela\Controllers\ModelController;
//#TODO Verifica la clase
use App\Models\Pos\Pagos;
use Marve\Ela\Core\CurrentUser;

class Pago extends ModelController
{
    /**
     */
    public function __construct() 
    {                
      $this->class = new Pagos(CurrentUser::getDb());
      parent::__construct("PagID");        
    } 
    
    protected function aCliente($data)
    {
      $this->request = $this->class->aCliente($data);
      return $this->request;
    }
    protected function adeudos($data)
    {
      $this->request= $this->class->adeudos(["limite1"=>$data->limite1,"limite2"=>$data->limite2]);
      return $this->request;
    }

    protected function cliente($data)
    {
      $this->request = $this->class->cliente($data->cliente);
      return $this->request;
    }
}
