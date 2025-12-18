<?php

use App\Grids\Proveedores as GridsProveedores;
use App\Models\Catalogos\Proveedores;
use Marve\Ela\Core\CurrentUser;
use Marve\Ela\Grid\Datagrid;

$PROVEEDOR = new Proveedores(CurrentUser::getDb());

$GRID = new Datagrid();
$GRID->inicio(CurrentUser::getDb());
$editar = CurrentUser::isSupervisor();

$link = ($editar)?"/Dashboard/Proveedor/{ProvID}":"";

$GRID->campos(GridsProveedores::grid(array("link"=>$link,"editar"=>$editar, "options"=>"class='box'")));
$GRID->encabezado("Proveedores", "ProvRazon", array(
    false,true,false,true,true), "desc", 500);
$GRID->sql("select distinct * from proveedores", "proveedores");
$proveedor = $GRID->mostrar();



 echo $proveedor; ?>
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
  		        'caption'      : 'Agregar Proveedor', 
  		        'buttonicon'   : 'ui-icon-plus', 
  		        'onClickButton': function()
  		        {
  		        	$.colorbox({iframe:true,href:"/Dashboard/Proveedor",width:"98%", height:"98%", onClosed:refrescar});  	  		       	
  		        },
  		        'position': 'first'
  		    });    	  	
			
			  	
		    add_button = true;
		   
	  	}  	
	  	$(".box").colorbox({iframe:true, width:"98%", height:"98%", onClosed:refrescar});  	  
	  	
	  });
	
    $(".box").colorbox({iframe:true, width:"98%", height:"98%", onClosed:refrescar});  	
	
});


function refrescar()
{
	$("#list1").trigger("reloadGrid", [{current:true}]);
}
</script>
