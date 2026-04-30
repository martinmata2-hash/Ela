<?php
namespace App\Controllers;
use Marve\Ela\Controllers\ModelController;
//#TODO Verifica la clase
use App\Models\<classComplete>;
use Marve\Ela\Core\CurrentUser;

class <controller> extends ModelController
{
    /**
     */
    public function __construct() 
    {                
      $this->class = new <modelo>(CurrentUser::getDb());
      parent::__construct("<key>");        
    }           
}
