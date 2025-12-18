<?php

use App\Core\Access;
use App\Enum\Permiso;
use App\Grids\Clientes as GridsClientes;
use App\Models\Catalogos\Clientes;
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
$GRID->campos(GridsClientes::grid(["rutas"=>$rutas, "link"=>$link,"editar"=>$editar, "options"=>"class='box'"]));
$GRID->encabezado("Clientes", "CliNombre", array(
    false,true,false,true,true), "desc", 500);
$GRID->sql("select distinct *, CliID as ID from clientes $where", "clientes");
$clientes = $GRID->mostrar();


echo $clientes; ?>

<input id='CSRF' type='hidden' value='<?php echo CurrentUser::getCsrf(); ?>' /> 
<script>
var add_button = false;

$(document).ready(function()
{   
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
	$("#list1").trigger("reloadGrid", [{current:true}]);
}
</script>
