<?php

use App\Grids\Descuentos as GridsDescuentos;
use App\Models\Pos\Descuentos;
use Marve\Ela\Core\CurrentUser;
use Marve\Ela\Grid\Datagrid;


$DESCUENTOS = new Descuentos();
////////////////Descuentos

$GRID = new Datagrid();
$GRID->inicio(CurrentUser::getDb());

$editar = CurrentUser::isAdmin();

$link = ($editar)?"/Dashboard/Descuento/{DesID}":"";

$GRID->campos(GridsDescuentos::grid(array("link"=>$link,"editar"=>$editar, "options"=>"class='box'")));
$GRID->encabezado("Descuentos y Promosiones", "DesInicia", array(
    false,true,false,true,true), "desc", 500);
$GRID->sql("select distinct DesID, DesDescripcion, if(DesTipo=0,'Descuento','Promosion') as tipo, DesInicia, DesTermina, 
    if(DesTipo = 0, concat('$ ',DesPorcentaje), concat(DesPrecio, ' %')) as precio, DesCondicion  from descuentos", "descuentos");
$descuentos = $GRID->mostrar();

 echo $descuentos; ?>
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
  		        'caption'      : 'Agregar Descuento', 
  		        'buttonicon'   : 'ui-icon-plus', 
  		        'onClickButton': function()
  		        {
  		        	$.colorbox({iframe:true,href:"/Dashboard/Descuento",width:"98%", height:"98%"});  	  		       	
  		        },
  		        'position': 'first'
  		    });    	  	
			
			  	
		    add_button = true;
		   
	  	}  	
	  	$(".box").colorbox({iframe:true, width:"98%", height:"98%", onClosed:refrescar});  	  
	  	
	  });
	
    $(".box").colorbox({iframe:true, width:"98%", height:"98%"});  	
	
});


function refrescar()
{
	$("#list1").trigger("reloadGrid", [{current:true}]);
}
</script>
