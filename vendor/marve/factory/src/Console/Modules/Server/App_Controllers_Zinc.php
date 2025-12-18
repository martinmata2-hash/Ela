<?php
namespace App\Controllers;
use App\Models\Rpc\JsonRpcClient;
use Marve\Ela\Controllers\ModelController;
//#TODO Verifica la clase
use App\Models\Zinc as ModelZinc;
use Marve\Ela\Core\ArraytoObject;
use Marve\Ela\Core\CurrentUser;
use stdClass;

class Zinc extends ModelController
{
    /**
     */
    public function __construct() 
    {                
      $this->class = new ModelZinc(CurrentUser::getDb());
      parent::__construct("ZinID");        
    }           

    protected function update($data)
    {
      $clases = $this->class->get(0);      
      foreach ($clases as $key => $value) 
      {       
        $myclass = new $value->ZinClass();                      
        $datos = $myclass->get("0","","updated <> 1");        
        $RPCCLIENTE = new JsonRpcClient("https://pos.facilpv.com/JsonRcp/Server.php");
        foreach ($datos as $k => $v) 
        {
          $params = [
            "data"=>$v,
            "credentials"=>CurrentUser::getCredenciales(),
            "action"=>$v->updated
          ];                         
          $request = $RPCCLIENTE->call($myclass::class,$params);                                      
          if($request !== 0)
          {
            $updated = new stdClass();
            $updated->updated = 1;            
            $myclass->updateDirect($updated,$v->{$request[0]}, $request[0]);            
          }
          else
          {
            echo print_r($request,true);
          }
        }
      }
      $this->request = 1;
      return $this->request;
    }
}
