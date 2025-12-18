<?php
namespace App\Core;

use App\Models\Data\PagesD;
use Marve\Ela\Core\CurrentUser;
use Marve\Ela\Core\DotEnv;
use Marve\Ela\Core\Model;
use Marve\Ela\MySql\Interfaces\DatabaseInterface;

class Pages extends Model implements DatabaseInterface
{
   

    /**
     *
     * @var PagesD
     */
    public $data;
    
    public function __construct( $data_base = "")
    {
        if($data_base == "")
            $data_base = DotEnv::getDB();
        $this->data_base = $data_base;
        $this->mensaje = array();        
        parent::__construct($data_base, "archivos");
        
        //Inicar tabla
        $this->createTable(new PagesD());
        $this->updateTable();
    }

    public function remove(string $id, string $campo="ArcID",  int $usuario = 0)
    {
        if(CurrentUser::isAdmin())
           return  parent::remove($id,$campo,$usuario);
        else return 0;
    }   
    
    public function getModule($module)
    {
        $respuesta = $this->get(0,"ArcModulo", "ArcModulo = $module");
        if (\count($respuesta) > 0)
            return $respuesta;
        else
            return 0;
    }
        
}
