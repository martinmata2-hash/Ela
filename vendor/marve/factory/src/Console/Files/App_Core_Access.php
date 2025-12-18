<?php
namespace App\Core;

use App\Enum\Permiso;
use App\Models\Data\AccessD;
use Marve\Ela\Core\CurrentUser;
use Marve\Ela\Core\DotEnv;
use Marve\Ela\Core\Generic;
use Marve\Ela\Core\Model;
use Marve\Ela\Interfaces\MiddlewareHandleInterface;
use Marve\Ela\MySql\Interfaces\DatabaseInterface;
use stdClass;

class Access extends Model implements MiddlewareHandleInterface
{
   
      
    /**
     *
     * @var array
     */
    public $mensaje;
    /**
     *
     * @var AccessD
     */
    public $data;

    public function __construct( $data_base = "")
    {
        if($data_base == "")
            $data_base = DotEnv::getDB();
        $this->data_base = $data_base;
        $this->mensaje = array();        
        parent::__construct($data_base, "permisos");
        
        //Inicar tabla
        $this->createTable(new AccessD());
        $this->updateTable();
    }

    public function remove(string $id, string $campo="PusID",  int $usuario = 0)
    {
        if(CurrentUser::isAdmin())
           return  parent::remove($id,$campo,$usuario);
        else return 0;
    }
  
  
    
    public function permission($pagina)
    {        
        $access = $this->get(CurrentUser::getId(),"PusUsuario");
        if($access !== 0)
        $pages = explode(",", $access->PusPermisos);
        $PAGINA = new Generic($this->data_base, "archivos");
        $pagid = $PAGINA->get($pagina,"ArcPath");
        if($pagid !== 0)
            return in_array($pagid->ArcID, $pages);
        else return false;
    }
    
    public function addEdit($usuario, Permiso $permiso)
    {
        $PERMISOS = new Generic(CurrentUser::getDb(), "permisosespeciales");
        $permisos = $PERMISOS->get($usuario,"PerUsuario");        
        return match ($permiso) 
        {
             Permiso::Agregar => $permisos->PerAdd == 1,
             Permiso::Editar => $permisos->PerEdit == 1,
             default => false
             
        };        
    }
    /**
     * Summary of render
     * @param int $usuario
     * @return string
     */
    public function render($usuario = 0)
    {
        $modulo = "0";
        $html = "<div class='row row gx-5 justify-content-center'>";
        $secciones = $this->query("*", "modulos", ($usuario == 1)?"0":"ModRol > 1");
        $count = 0;
        foreach ($secciones as $seccion)
        {
            if($count++ > 2)
            {
                $count = 0;                
            }
            else $end = "";
            $pages = $this->query("*", "archivos","ArcModulo = ".$seccion->ModID,  "ArcOrden");
            if(count($pages) > 0)
            {
                $html .= "<div class='col-md-4'>";
                $html .= "  <h5> ".$seccion->ModNombre."  </h5>";
                $html .= "  <ul class='list-group' style='margin-left:0.5rem;'>";                                
                foreach ($pages as $page)
                {
                    $html .= "      <li class='list-group-item'>
                                        <div class='form-check'>                                            
                                        <input class='form-check-input permisos' type='checkbox' id='id_".$page->ArcID."' value='".$page->ArcID."' />
                                        <label  class='form-check-label' for='id_".$page->ArcID."' >".$page->ArcNombre."</label>
                                            
                                        </div>
                                </li>";
                    
                }
                
                $html .= "        </ul>";
                $html .= "      </li>";
                $html .= "    </ul>";
                $html .= "</div>";
            }
        }       
        $html .= "</div>";
        $html .= "<div class='col-md-4'>
                    <ul class='list-group' style='margin-left:0.5rem;'>
                        <li class='list-group-item'>
                            <div class='form-check'>                                            
                                <input class='form-check-input permisosEspecial' type='checkbox' id='PerAdd' value='PerAdd' />
                                <label  class='form-check-label' for='Add' >Agregar nuevos</label>
                            </div> 
                        </li>
                        <li class='list-group-item'>
                            <div class='form-check'>                                            
                                <input class='form-check-input permisosEspecial' type='checkbox' id='PerEdit' value='PerEdit' />
                                <label  class='form-check-label' for='Edit' >Editar existentes</label>                                            
                            </div>
                        </li>
                    </ul>
                </div>";                
        return $html;
    }
        
    public function handle(array $auth)
    {       
        $aproved = $this->permission($auth["page"]); 
        if(isset($auth["permisos"]))            
            return $this->addEdit(CurrentUser::getId(), Permiso::from($auth["permisos"]));
        return $aproved;       
    }        

    public function getAccess($user)
    {
         $access = $this->get(CurrentUser::getId(),"PusUsuario");
        if($access !== 0)
        {
            $pages = explode(",", $access->PusPermisos);
            $PAGINA = new Generic($this->data_base, "archivos");
            return  $PAGINA->get($pages[0],"ArcID")->ArcPath;
        }
        else return 0;
    }
}

