<?php
namespace App\Core;



use App\Models\Data\UserD;
use Marve\Ela\Core\CurrentUser;
use Marve\Ela\Core\DotEnv;
use Marve\Ela\Core\Model;
use Marve\Ela\Html\Form\Form;
use Marve\Ela\Html\Form\Input;
use Marve\Ela\Html\Form\Seccion;
use Marve\Ela\MySql\Interfaces\DatabaseInterface;
use Marve\Ela\MySql\Interfaces\ListInterface;
use stdClass;

class User extends Model
{
       
    /**
     *
     * @var UserD
     */
    public $data;

    public function __construct( $data_base = "")
    {
        if($data_base == "")
            $data_base = DotEnv::getDB();
        $this->data_base = $data_base;
        $this->message = array();        
        parent::__construct($data_base, "usuarios");
        
        //Inicar tabla
        $this->createTable(new UserD());
        $this->updateTable();
        $this->editRules = [
            "UsuRol"=>"required|min:1",
            "UsuUsuario"=>"required|",
            "UsuClave"=>"required|min:4",
            //"UsuEmpresa"=>"required|",
        ];
        $this->addRules = [
            "UsuRol"=>"required|min:1",
            "UsuUsuario"=>"required|unique:UsuUsuario",
            "UsuClave"=>"required|min:4",
            //"UsuEmpresa"=>"required|",
        ];
    }

    /**
     
     * Summary of remove
     * @param string $id
     * @param string $campo
     * @param int $usuario
     * @return int
     */
    public function remove(string $id, string $campo="UsuID",  int $usuario = 0)
    {
        if(CurrentUser::isAdmin())
           return  parent::remove($id,$campo,$usuario);
        else return 0;
    }    			
}
