<?php 
namespace App\Core;
use Marve\Ela\Core\CurrentUser;
use Marve\Ela\Core\DotEnv;
use Marve\Ela\Core\Generic;
use Marve\Ela\Core\Session;

class Menu extends Pages
{
    /**
     * modulos
     * @var array
     */
    protected $modules;

    /**
     * paginas
     * @var array
     */
    protected $pages;

    public $activeModulo;
    protected $activePage;
    function __construct($data_base = "")
    {
        if($data_base == "")
            $data_base = DotEnv::getDB();
        parent::__construct($data_base);
        $this->modules = [];
        $this->pages = [];
        $this->activeModulo = "";
        $this->activePage = "";
    }

    public function getModulos()
    {               
        $ACCESS = new Access();
        $MODULO = new Generic($this->data_base,"modulos");
        $access = $ACCESS->get(CurrentUser::getId(),"PusUsuario");        
        if($access !== 0)
        {
            $files = explode(",",$access->PusPermisos);
            foreach ($files as $page) 
            {
                $file = $this->get($page,"ArcID");
                if($file !== 0)
                {
                    $modulo = $MODULO->get($file->ArcModulo,"ModID");
                    if( in_array($modulo, $this->modules) === false)
                        $this->modules[] = $modulo;                    
                }
            }
        }
        return $this->modules;
    }   

    public function getPages()
    {               
        $ACCESS = new Access();        
        $access = $ACCESS->get(CurrentUser::getId(),"PusUsuario");                
        if($access !== 0)
        {
            $files = explode(",",$access->PusPermisos);
            foreach ($files as $page) 
            {
                $file = $this->get($page,"ArcID");
                if($file !== 0)
                {
                    if($file->ArcModulo == $this->activeModulo)                    
                    {
                        $this->pages[] = $file;
                    }
                }
            }
        }
        return $this;
    }
    public function setModulo($modulo)
    {       
        $this->activeModulo = $modulo;
        return $this;
    }

    public function setPage($page)
    {
        $this->activePage = $page;
        return $this;
    }
    /**
     * Render el Menu
     * @return string
     */
    public function render()
    {                
        $html = "";
        if($this->pages !== [])            
        foreach ($this->pages as $key=>$value) 
        {       
            if($this->activePage == $value->ArcNombre)
                $active = "active";
            else
                $active = "";
            $html.= 
            "<li class='nav-item $active'>
            <a class='nav-link' href='/Dashboard/$value->ArcPath'>
                    <i class='$value->ArcIcon'></i>
            <span>$value->ArcNombre</span>                                        
            </a>
            </li>";                                       
        }
        return $html;
    }

}