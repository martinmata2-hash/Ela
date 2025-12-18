<?php
namespace App\Controllers;
use Marve\Ela\Controllers\ModelController;
use App\Models\Catalogos\Clientes;
use Marve\Ela\Core\CurrentUser;

class Cliente extends ModelController
{
    /**
     */
    public function __construct() 
    {                
      $this->class = new Clientes(CurrentUser::getDb());
      parent::__construct("CliID");        
    }        
    
      protected function pagos($data)
    {
        $this->request = $this->class->pagos($data->cliente);
        return $this->request;
    }
}
