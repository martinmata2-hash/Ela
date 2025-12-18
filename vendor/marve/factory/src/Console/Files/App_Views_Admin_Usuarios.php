<?php

/**
 *
 * @version v2022_1
 *         
 * @author Martin Mata
 *        
 */

use App\Core\Login;
use App\Core\User;
use App\Forms\Users as FormsUser;
use App\Grids\Users as GridUser;
use Marve\Ela\Core\CurrentUser;
use Marve\Ela\Core\DotEnv;
use Marve\Ela\Grid\Datagrid;
use Marve\Ela\Html\Form\Select;

global $params;


$LOGIN = new Login();
$USUARIOS = new User(CurrentUser::getDb());

//$ROL = new Rol();

if(isset($params["UsuID"]) && $params["UsuID"] > 0)
{
	$usuario = $USUARIOS->get($params["UsuID"], "UsuID");
}
else
	$usuario = $USUARIOS->get(CurrentUser::getId(), "UsuID");

$GRID = new Datagrid();
$GRID->inicio(CurrentUser::getDb());      

$editar = CurrentUser::isAdmin();
$roles = $GRID->g->get_dropdown_values("select distinct RolID as k, RolNombre as v from rol where RolID > ".CurrentUser::getRol());

$link = "";// $inicio."Usuario/{UsuID}";

$permiso = "<a style='color:white !important' class='box btn btn-primary' href='/Dashboard/Permisos/{UsuID}'>Permisos</a>";
$GRID->campos(GridUser::grid(array("editar"=>$editar,"rol"=>$roles, "link"=>$link, 
    "permiso"=>$permiso)));
$GRID->encabezado("Usuarios", "UsuID", array(false, true, false, true, false), "desc", "420");
$GRID->sql("Select * from usuarios", "usuarios");
$out = $GRID->mostrar();



if (CurrentUser::isAdmin())
{    
	echo FormsUser::usuario();
	/*
	$FORMA = new Form("4",false, false);
	$FORMA->fields("usuarioForma","usuarioForma","Datos de Usuario");
		$EMPRESA = new Input(((Session::getRol() == 1)?"text":"readonly"));
		$EMPRESA->fields("UsuEmpresa","UsuEmpresa","Empresa")
		->value(Session::getBussiness());
    $FORMA->add($EMPRESA);
		$NOMBRE = new Input("text");
		$NOMBRE->fields("UsuNombre","UsuNombre","Nombre Completo")
		->validation("nombre",true,"Usuarios",true)
    	->hidden("","CSRF", Session::getCsrf())
		->hidden("UsuID", "UsuID");
    $FORMA->add($NOMBRE);
        $USU = new Input("text");
        $USU->fields("UsuUsuario","UsuUsuario","Usuario")
        ->validation("usuario",true,"Usuario",true)
		->hidden("UsuBd","UsuBd",CurrentUser::getDb());
    $FORMA->add($USU);
        $CLAVE = new Input("text");
        $CLAVE->fields("UsuClave","UsuClave","Clave")
        ->validation("length",false,"Usuario",true,3);
    $FORMA->add($CLAVE);
        $ROL = new Select();
        $ROL->fields("UsuRol","UsuRol","Función")
        ->fromDB(CurrentUser::getDb(),"rol", "RolNombre","RolID","0","RolID > ".Session::getRol());
    $FORMA->add($ROL);
    echo $FORMA->render();
    */
    /*
	echo "<h3>Datos del nuevo usuario</h3>";
	echo $USUARIOS->forma(array("rol" => $roles));
	*/
    echo "<br/><hr/>";
	echo $out;	
	echo "<hr>";	

	$INPUT = new Select();
	$INPUT->fields("UsuID","UsuID2","Cambiar Clave de Usuarios")
	->fromDB(DotEnv::getDB(),"usuarios", "UsuNombre","UsuID","0","UsuActivo = 1");
	echo $INPUT->render();
	if(isset($_GET["UsuID"]))
	{
		$usuario = $USUARIOS->get($_GET["UsuID"], "UsuID");
		echo FormsUser::renewPassword($usuario);
	}
	/*
	$FORMA = new Form(4, false, false);
	$FORMA->fields("claveForma","claveForma","Cambiar Clave");
		$NOMBRE = new Select();
        $NOMBRE->fields("","Nombres","Usuarios")
        ->fromDB(CurrentUser::getDb(),"usuarios", "UsuNombre","UsuID",$usuario->UsuID,"UsuActivo = 1");
    $FORMA->add($NOMBRE);
		$NOMBRE2 = new Input("readonly");
		$NOMBRE2->fields("","UsuNombre2","Nombre")->value($usuario->UsuNombre)
		->hidden("UsuID2","UsuID2", $usuario->UsuID);
	$FORMA->add($NOMBRE2);
		$CLAVE = new Input("text");
		$CLAVE->fields("UsuClave1","UsuClave1","Clave");
	$FORMA->add($CLAVE);
		$CLAVE2 = new Input("text");
		$CLAVE2->fields("","UsuClave2","Repetir Clave");
	$FORMA->add($CLAVE2);		
	echo $FORMA->render();
	*/
}

?>

<script type="module" src="/Dashboard/js/Form/post.js"></script>
<script type="module" src="/Dashboard/js/Form/validar.js?v1"></script>
<script type="module" src="/Dashboard/js/Form/forma.js"></script>

<script>
	var AjaxPeticiones;
	var Forma;	
    var Forma2;
</script>
<script type="module">
import { Form } from "/Dashboard/js/Form/forma.js";
import { Request }from "/Dashboard/js/Ajax/request.js";

	AjaxPeticiones = new Request();
 	Forma = new Form(
		$("#usuarioForma"), //forma
		$('#submitusuarioForma'),//submit button
		"/Dashboard/Ajax/Controller.php", //controller
		"Login/store", //accion controller
		"Usuario Agregado...", //mensaje al terminar
		refrescar
	);
    Forma2 = Forma;

	</script>


<script>
var add_button = false;
$(document).ready(function()
{
	$("#UsuID2").change(function(){window.location.href="/Dashboard/Admin?UsuID="+$("#UsuID2").val();});
	$(document).ajaxComplete(function( event,request, settings )
	  {	  	  
	  		$(".box").colorbox({iframe:true, width:"90%", height:"90%"});  	  	  	
	  });
	
	$("#Nombres").change(function(){window.location.replace("/Dashboard/Admin/"+$("#Nombres").val())});
	$("#UsuClave2").change(function()
	{
		if($("#UsuClave2").val() != $("#UsuClave1").val())
		$("#UsuClave2").notify("La clave no es igual", "error");
	});
	$("#usuarioForma").submit(function(event)
	{
		Forma.handleSubmit(event);		
	});	

	$("#claveForma").submit(function(event)
	{
		Forma2.submit = $("#submitButtonUsuario2");
		Forma2.forma = $("#claveForma");
		Forma2.handleSubmit(event);
	});		
		
});
function refrescar(registro)
	{          	    
		location.reload();										
	}
</script>
