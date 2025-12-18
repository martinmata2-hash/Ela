<?php

use App\Core\Access;
use App\Enum\Permiso;
use App\Forms\Clientes as FormsClientes;
use App\Grids\Clientes as GridsClientes;
use App\Models\Catalogos\Clientes;
use App\Models\Gym\Inscripcion;
use Marve\Ela\Core\CurrentUser;
use Marve\Ela\Grid\Datagrid;

$CLIENTE = new Clientes(CurrentUser::getDb());
////////////////Clientes

$GRID = new Datagrid(); 
$GRID->inicio(CurrentUser::getDb());

if(CurrentUser::isSupervisor())
{
	//Todos los clientes
    $where = "";
    $editar = true;
    $ediusuario = true;
}
else
{	
	//Solo Clientes activos
    $where = "Where CliEstatus = 0";
    $editar = (new Access())->addEdit(CurrentUser::getId(),Permiso::Editar);
    $ediusuario = false;
}

$link = ($editar)?"/Dashboard/Cliente/{CliID}":"";
$pago ="<a style='color:white !important' class='btn btn-primary box' href='/Dashboard/Pago/{CliID}'>Pagar</a>";
$membresias = $GRID->g->get_dropdown_values("select distinct MemID as k, MemNombre as v from membresias");
$GRID->campos(GridsClientes::grid(
	["rutas"=>$rutas, "link"=>$link,"editar"=>$editar, 
	"options"=>"class='box'", "pagar"=>$pago, "membresias"=>$membresias]));
$GRID->encabezado("Clientes", "CliNombre", array(
    false,$editar,false,true,true), "desc", 500);
$GRID->sql("select distinct *, CliID as ID from clientes $where", "clientes");
$clientes = $GRID->mostrar();

echo FormsClientes::formRapido();
echo "<br/>";
echo $clientes; ?>

<script type="module" src="/Dashboard/js/Form/post.js"></script>
<script type="module" src="/Dashboard/js/Form/validar.js?v1"></script>
<script type="module" src="/Dashboard/js/Form/forma.js"></script>

<script type="module">
	import {
		Form
	} from "/Dashboard/js/Form/forma.js";

	Forma = new Form(
		$("#registroRapidoForma"), //forma
		$('#submitregistroRapidoForma'), //submit button
		"/Dashboard/Ajax/Controller.php", //controller		
		"Cliente/beforeStore", //accion controller
		"Cliente Agregado...", //mensaje al terminar
		refrescarCliente
	);
</script>
<script>
var add_button = false;

$(document).ready(function()
{   
	$("#registroRapidoForma").on('submit',
			function(event) {
				Forma.handleSubmit(event);
			}); //Asigna submit a Forma

	$(document).on("change", ".valida",
	function() {
		Forma.handleValidation($(this))
	}); //Asigna change a input 	
	
	$(document).ajaxComplete(function( event,request, settings )
	  {
	  	if(!add_button)
	  	{
    	  	$('#list1').jqGrid('navButtonAdd', '#list1_pager_left', 
  		    {  		       
  		        'caption'      : 'Agregar Clientes', 
  		        'buttonicon'   : 'ui-icon-plus', 
  		        'onClickButton': function()
  		        {
  		        	$.colorbox({iframe:true,href:"/Dashboard/Cliente",width:"98%", height:"98%"});  	  		       	
  		        },
  		        'position': 'first'
  		    });    	  							  	
		    add_button = true;		   
	  	}  	
	  	$(".box").colorbox({iframe:true, width:"98%", height:"98%", onClosed:refrescarCliente});  	  
	  	
	  });
	
    $(".box").colorbox({iframe:true, width:"98%", height:"98%"});  	
	
});
 

function refrescarCliente()
{
	//borrar nombre y celular
	$("#CliNombre").val("");
	$("#CliCelular").val("");
	$("#list1").trigger("reloadGrid", [{current:true}]);
}
</script>

<?php 

function ultimoPago($data)
{
    $proximo = (new Inscripcion(CurrentUser::getDb()))->get($data["CliID"],"InsCliente");	
	if($proximo !== 0)
	{
		return date("Y-m-d", strtotime($proximo->InsProximoPago));
	}
	else
	{
		return "N/D";
	}
}
