<?php

use App\Core\Access;
use App\Enum\Permiso;
use App\Grids\Productos as GridsProductos;
use App\Models\Catalogos\Productos;
use Marve\Ela\Core\CurrentUser;
use Marve\Ela\Grid\Datagrid;

@session_start();


$PRODUCTOS = new Productos(CurrentUser::getDb());
//catalogos database

$GRID = new Datagrid();
$GRID->inicio(CurrentUser::getDb());

if(CurrentUser::isSupervisor())
{
   
		$editar = true;		   
}
else
{   
    $editar = (new Access())->addEdit(CurrentUser::getId(),Permiso::Editar);	
}

$f = array();
$f["column"] = "InvCantidad";
$f["op"] = "<";
$f["value"] = "3";
$f["css"] = "'background-color':'#FC4C02', 'color':'white'";
$f_conditions[] = $f;

$GRID->g->set_conditional_css($f_conditions);

$link = ($editar)?"/Dashboard/Producto/{ProID}":"";

$categoria = $GRID->g->get_dropdown_values("select distinct CatID as k, CatNombre as v from categorias order by CatNombre");
$subcategoria = $GRID->g->get_dropdown_values("select distinct SubID as k, SubNombre as v from subcat order by SubNombre");
$proveedor = $GRID->g->get_dropdown_values("select distinct ProvID as k, ProvRazon as v from proveedores order by ProvRazon");

$GRID->campos(GridsProductos::grid(array("link"=>$link,"editar"=>$editar, "options"=>"class='box'", 
"categorias"=>$categoria, "subcat"=>$subcategoria, "proveedores"=>$proveedor)));
$GRID->encabezado("Productos", "ProDescripcion", array(
    false,true,false,true,true), "desc", 500);
$GRID->sql("select distinct p.*, InvCantidad from 
    productos p inner join inventarios on InvProducto = ProID
	where TiendaID = 1"    
    , "productos");
$productos = $GRID->mostrar();

 echo $productos; ?>

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
  		        'caption'      : 'Agregar Producto', 
  		        'buttonicon'   : 'ui-icon-plus', 
  		        'onClickButton': function()
  		        {
  		        	$.colorbox({iframe:true,href:"/Dashboard/Producto",width:"98%", height:"98%"});  	  		         		
  		        },
  		        'position': 'first'
  		    });    	  							  	
		    add_button = true;		  
	  	}  	
	  	$(".box").colorbox({iframe:true, width:"98%", height:"98%", onClosed:refrescarProductos});  	  
	  	
	  });
	
	$(".box").colorbox({iframe:true, width:"98%", height:"98%", onClosed:refrescarProductos});  	
    
});
function refrescarProductos(respuesta)
{
	$("#list1").trigger("reloadGrid", [{current:true}]);
}

</script>
