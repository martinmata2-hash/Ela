<?php

/**
 *
 * @version 2022_1
 * @author Martin Mata
 */
namespace App\Core;


use App\Core\Access;
use App\Core\Menu;
use App\Core\Pages;

use Marve\Ela\Core\CurrentUser;
use Marve\Ela\Core\Session;
use Marve\Ela\Core\StringHelper;
use Marve\Ela\Interfaces\PageInterface;

class MainPage implements PageInterface
{
    /**
     * @var string
     */
    private $landingPage;

    /**
     * @var string
     */
    private $html;
    /**
     * @var array
     */
    private $pages;    
    /**
     * @var string
     */
    private $modulo;
    /**
     * @var bool
     */
    private $page;
    /**
     * @var Login
     */
    private $access;
    
    private $url = "";  //website url
    
    /**
     * 
     * @var array
     */
    private $accessList;

    private $file;

    private $currentuser;

    private $timbres;

    private $MENUCLASS;

    public function __construct(string $landingPage, string $archivo)
    {   
        @session_start();        
        $landingPage = str_replace("/","", $landingPage);
        $this->access = new Access();        
        if($landingPage != "Login")
        {
            if(!CurrentUser::getDb())
            {
                header("Location: /Dashboard/Login");
                exit();
            }
        }
        if($landingPage == "Login")
        {
            $this->accessList = [];
        }
        else 
        {            
            $this->accessList = explode(",",$this->access->get(Session::getId(), "PusUsuario")->PusPermisos);         
        }
        
        $this->MENUCLASS = new Menu();
        $this->pages = [];
        $this->page = false;
        $this->landingPage = $landingPage;
        $this->file = $archivo;
        $this->MENUCLASS->setPage($landingPage);
        
        
        $PAGINAS = new Pages();
        foreach ($this->accessList as $permiso) 
        {            
            $this->pages[] = $PAGINAS->get($permiso,"ArcID");
        }        
               
        $this->modulo = 0;
        if(count($this->pages) > 0)
            foreach ($this->pages as $pagina)
            {
                if($pagina->ArcPath == $this->landingPage)
                {                            
                    $this->modulo = $pagina->ArcModulo;  
                    $this->MENUCLASS->setModulo($this->modulo);              
                    break;
                }
            }           
      
    }

    public function render()
    {
        $this->header();
        $this->appContainerInit();
        $this->menu();
        $this->body();        
        $this->footer();
        return $this->html;
    } 

    public function header()
    {        
        $this->html =
            "
        <!DOCTYPE html>
<html lang='es'>

    <head>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title>GPO SANMIGUEL-SILVA</title>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <meta name='robots' content='all,follow'>

        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css'
            integrity='sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH' crossorigin='anonymous'>

        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css'>
        <link rel='shortcut icon' href='/Dashboard/img/logo.png'>

        <script src='https://use.fontawesome.com/releases/v6.3.0/js/all.js' crossorigin='anonymous'></script>
        <link href='/Dashboard/fontawesome-free/css/all.min.css' rel='stylesheet' type='text/css'>
         <link
        href='https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i'
        rel='stylesheet'>

        <!-- Core theme CSS (includes Colorbox)-->
        <link href='/Dashboard/css/Colorbox/colorbox.css' rel='stylesheet' />
        <link href='/Dashboard/css/sb-admin-2.css' rel='stylesheet' />

        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js'></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.14.1/jquery-ui.min.js'></script>


        <link href='/vendor/marve/ela/src/Grid/css/ui.jqgrid.css' rel='stylesheet' type='text/css' media='screen'>
        <!-- EL orden de locale-es.js debe de ser antes de jqGrid -->
        <script src='/vendor/marve/ela/src/Grid/js/i18n/grid.locale-es.js' type='text/javascript'></script>
        <script src='/vendor/marve/ela/src/Grid/js/jquery.jqGrid.min.js' type='text/javascript'></script>


        <link href='/vendor/marve/ela/src/Grid/css/themes/redmond/jquery-ui.custom.css' rel='stylesheet' type='text/css'
            media='screen' />
        <link href='/Dashboard/css/grid-overwrite.css' rel='stylesheet' type='text/css' media='screen'>

        <style>
            .lineonly {
                width: 80%;
                text-align: right;
                background: transparent;
                border: none;
                -webkit-box-shadow: none;
                box-shadow: none;
            }

            .blink {
                animation: blink-animation 1s steps(5, start) infinite;
                -webkit-animation: blink-animation 1s steps(5, start) infinite;
            }

            @keyframes blink-animation {
                to {
                    visibility: hidden;
                }
            }

            @-webkit-keyframes blink-animation {
                to {
                    visibility: hidden;
                }
            }
        </style>
        <script src='https://cdn.jsdelivr.net/npm/chart.js'></script>
        <script type='module' src='/Dashboard/js/Form/post.js'></script>
        <script type='module' src='/Dashboard/js/Ajax/request.js'></script>
        <script type='module' src='/Dashboard/js/Form/validar.js'></script>
        <script type='module' src='/Dashboard/js/Form/unico.js'></script>
        <script type='module' src='/Dashboard/js/Form/forma.js'></script>
        <script src='/Dashboard/js/Form/filler.js'></script>
        <script>
            var AjaxPeticiones;
            var Forma;
            var INICIO = '/Dashboard/';
            var classValid = 'border-success text-primary';
            var classInvalid = 'border-danger text-danger';
            var TiendaID = 1;
        </script>

        <script type='module'>
            import { Request } from '/Dashboard/js/Ajax/request.js';
            AjaxPeticiones = new Request(); 	                                                                  
        </script>

    </head>
        ";
        

    }
    public function menu()
    {                       
      if(count($this->pages) > 0)
            foreach ($this->pages as $value) 
            {                           
                if($value->ArcPath == $this->landingPage)
                {             
                  $this->page = true; 
                  $this->sideMenu();         
                  $this->appContainerEnd(); 
                  $this->headerMenu();                                                                                                                
                }                
            }    
    }

    public function appContainerInit()
    {
              
      $this->html .=      
      "             
      <body id='page-top'>
        <!-- Page Wrapper -->
        <div id='wrapper'>
      
      ";
          
    }
    
    public function appContainerEnd()
    {
      $this->html .=      
      "
        <div id='content-wrapper' class='d-flex flex-column'>
                <!-- Main Content -->
                <div id='content'>      
      ";
      

    }
    public function sideMenu()
    {        
        if($this->landingPage == "Login")
        {
            $this->currentuser = "Invitado";
            $rol = "Invitado";
        }
        else
        {
            $this->currentuser = CurrentUser::getName();
            //$rol = $this->Rol->obtener(Session::getRol(), 'RolID')->RolNombre;
        }
        
        $this->html .=
            
        "
         <ul class='navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled' id='accordionSidebar'>

            <!-- Sidebar - Brand -->
            <a class='sidebar-brand d-flex align-items-center justify-content-center' href='/Dashboard/Ventas'>
                <div class='sidebar-brand-icon'>
                    ".StringHelper::iniciales(CurrentUser::getName())."
                </div>
                <div class='sidebar-brand-text mx-3'>".CurrentUser::getName()."</div>
            </a>

            <!-- Divider -->
            <hr class='sidebar-divider my-0'>

            <!-- Nav Item - Dashboard -->
            <li class='nav-item'>
                <a class='nav-link collapsed' href='#' data-toggle='collapse' data-target='#collapseDashboard' aria-expanded='false' aria-controls='collapseDashboard'>
                <i class='fas fa-fw fa-tachometer-alt'></i>
                <span>Dashboard</span></a>
                <!--
                <div id='collapseDashboard' class='collapse' aria-labelledby='headingDashboard' data-parent='#accordionSidebar'>
                    <div class='bg-white py-2 collapse-inner rounded'>
                        <h6 class='collapse-header'>Dashboard:</h6>
                        <a class='collapse-item' href='/Dashboard/Reportes-Ventas'>Reporte - Ventas</a>
                        <a class='collapse-item' href='/Dashboard/Reportes-Cobranza'>Reporte - Cobranza</a>
                        <a class='collapse-item' href='/Dashboard/Reportes-Productos'>Reporte - Productos</a>
                    </div>
                </div>
                -->
            </li>

            <!-- Divider -->
            <hr class='sidebar-divider'>

            <!-- Heading -->
            <div class='sidebar-heading'>
                Interface
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            ";

            //$MENU->setModulo($this->modulo);
            $this->html .= $this->MENUCLASS->getPages()->render();

            $this->html .="
            
            <!-- Divider -->
            <hr class='sidebar-divider d-none d-md-block'>

            <!-- Sidebar Toggler (Sidebar) -->
            <div class='text-center d-none d-md-inline'>
                <button class='rounded-circle border-0' id='sidebarToggle'>                                   
                </button>
            </div>

            <!-- Sidebar Message -->           

        </ul>
        ";
    }

    public function headerMenu()
    {   
        /*         
        $TIENDAS = new Generico(Session::getBd(), "tiendas");    
        if(Session::getTienda())
            $tienda = Session::getTiendaNombre();
        else $tienda = "";
        */
        $this->html .= "

       <nav class='navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow'>

                        <!-- Sidebar Toggle (Topbar) -->
                        <button id='sidebarToggleTop' class='btn btn-link d-md-none rounded-circle mr-3'>
                            <i class='fa fa-bars'></i>
                        </button>

                        <!-- Topbar Search -->
                        <h5>".strtoupper(CurrentUser::getBussiness())."
                       ".StringHelper::procesaPath($this->landingPage)."
                        </h5>
                        <!-- Topbar Navbar -->
                        <ul class='navbar-nav ml-auto'>";

                        $headerMenu = $this->MENUCLASS->getModulos();
                        //print_r($headerMenu);
                        foreach ($headerMenu as $key=> $item) 
                        {
                            if($item->ModID == $this->MENUCLASS->activeModulo)
                                $liClass = 'nav-item d-none d-md-block active fs-6';
                            else
                                $liClass = 'nav-item d-none d-md-block medium text-lowercase';
                            $this->html .= "<li class='$liClass'><a class='nav-link  text-primary' href='$item->ModPath'>$item->ModNombre</a></li>";
                        }
                        
                        foreach ($headerMenu as $key=> $item) 
                        {
                            if($item->ModID == $this->MENUCLASS->activeModulo)
                                $liClass = 'nav-item d-block d-sm-none active fs-6';
                            else
                                $liClass = 'nav-item d-block d-sm-none';
                            $this->html .= "<li class='$liClass'><a class='nav-link  text-primary' title='$item->ModNombre' 
                                href='$item->ModPath'>".StringHelper::iniciales($item->ModNombre)."</a></li>";
                        }
                        $this->html .="
                        

                            <!-- Nav Item - Alerts -->
                            <li class='nav-item dropdown no-arrow mx-1'>
                                <a class='nav-link box' href='/Dashboard/Backup' id='alertsDropdown'>
                                    <i class='fas fa-bell fa-fw'></i>
                                    <!-- Counter - Alerts -->
                                    <span class='badge badge-danger badge-counter'>0+</span>
                                </a>                                
                            </li>

                            <!-- Nav Item - Messages -->
                            <li class='nav-item dropdown no-arrow mx-1'>
                                <a class='nav-link box' href='/Dashboard/Mensajes' id='messagesDropdown'>
                                    <i class='fas fa-envelope fa-fw'></i>
                                    <!-- Counter - Messages -->
                                    <span class='badge badge-danger badge-counter'>0</span>
                                </a>                                
                            </li>

                            <div class='topbar-divider d-none d-sm-block'></div>

                            <!-- Nav Item - User Information -->
                            <li class='nav-item dropdown no-arrow'>
                                <a class='nav-link dropdown-toggle' href='/Dashboard/Salir' id='userDropdown'>
                                    <span class='mr-2 d-none d-lg-inline text-gray-600 small'>$this->currentuser</span>                                    
                                </a>                                
                            </li>

                        </ul>

                    </nav>
      ";		
    }


    public function body()
    {
        $this->html .= "             
                <div class='container-fluid'>";
                 ob_start();           
                        if(file_exists($this->file)) 
                          require($this->file);
                        else require("App/Views/404.php");
                    $this->html .= ob_get_clean();
                    $this->html .= "                 
                </div>
            ";
        
    }

    public function footer()
    {
        if($this->page)
        {
            $this->html .= " </div>
            <!-- End of Main Content -->                
        <!-- Footer -->        
        <footer class='sticky-footer bg-white'>
            <div class='container my-auto'>
                <div class='copyright text-center my-auto'>
                    <span>Copyright &copy; Gpo San Miguel 2025</span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->        
        </div>
        <a class='scroll-to-top rounded' href='#page-top'>
            <i class='fas fa-angle-up'></i>
        </a> ";
        }
    $this->html .= "    
</div>
            ";



           
        
        $this->html .="
        <!-- JavaScript files-->
         <script src='/Dashboard/js/sb-admin-2.min.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js' 
        integrity='sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz' crossorigin='anonymous'></script>
        <!-- Main File-->
         <!-- Overlay Scroll JS -->
                
        <script src='/Dashboard/js/notify.js'></script>
        
        <script src='/Dashboard/js/funsiones.js'></script>		        
        <script src='/Dashboard/js/Colorbox/jquery.colorbox.js'></script>
        <!--
        <script	src='/vendor/marve/ela/src/Grid/css/themes/jquery-ui.custom.min.js'
                type='text/javascript'></script>
        -->
        <script type='text/javascript' src='/vendor/marve/ela/src/Grid/js/datepicker-es.js'></script>
        <script src='/Dashboard/js/jquery.easing.min.js'></script>
        <script src='/Dashboard/js/bootsrap.min.js'></script>

        <script>
        
        $.fn.extend({
            toggleText: function(a, b){
                return this.text(this.text() == b ? a : b);
            }
        });        
            $('input, .noenter').keypress(function(e)
            {
                var key;
                if(window.event)
                    key = window.event.keyCode;
                else
                    key = e.which;
                return (key != 13);
            }); 
            
           $(document).on('keydown', enter);	

        function enter(e)
        {
            if(e.shiftKey)
            {			
                if(e.code == 'Enter')
                    $('.archivar:visible').trigger('click');                			
            }
        }	
            
            $('.box').colorbox({iframe:true, width:'90%', height:'90%'});
            $('#toggle-btn').trigger('click');
            
            ";
                                   
          $this->html .="                    
  
          function pagina_refrescar(respuesta)
          {
              location.reload();
          } 
         
        </script>       
        <script src='/Dashboard/js/script.js'></script>
    </body>
</html>";
        
    }
}