<?php


use App\Grids\Ventas as GridsVentas;
use App\Models\Catalogos\Clientes;
use App\Models\Pos\Presupuestos;

use Marve\Ela\Core\CurrentUser;
use Marve\Ela\Core\DotEnv;
use Marve\Ela\Grid\Datagrid;
use Marve\Ela\MySql\DateHelper;

@session_start();


global $inicio;

$VENTAS = new Presupuestos(CurrentUser::getDb());
$CLIENTES = new Clientes(CurrentUser::getDb());

if (isset($_GET["datefrom"]) && isset($_GET["dateto"]))
{
    $datos = DateHelper::range($_GET["datefrom"], $_GET["dateto"], "FacFecha");
}
else
{
    $datos = DateHelper::thisMonth("FacFecha");    
}

////////////////Ventas

$GRID = new Datagrid();
$GRID->inicio( CurrentUser::getDb());

$editar = CurrentUser::isUser(); 

$link = ($editar)?"/Dashboard/Presupuesto/{FacID}":"";
$formapago = array("value"=>"-1:SELECIONA;01:EFECTIVO;02:CHEQUE;03:TRANFERENCIA;04:TARJETA;08:VALE;28:DEBITO;99:MIXTA;100:PUNTOS");

$ticket ="<a style='color:white !important' class='btn btn-primary box' href='/Dashboard/Imprimir-Presupuesto/{FacID}'>Ticket</a>";
$pdf = "<a class='btn btn-primary box' href='/Dashboard/Imprimir-Presupuesto/{FacID}'>PDF</a>";
$usuarios = $GRID->g->get_dropdown_values("select distinct UsuID as k, UsuNombre as v from ".DotEnv::getDB().".usuarios where UsuActivo = 1");
$hide = !CurrentUser::isAdmin();

$GRID->campos(GridsVentas::grid(array("link"=>$link,"editar"=>$editar, "options"=>"class='box'","formapago"=>$formapago,
        "imprimir"=>"$ticket", "usuarios"=>$usuarios, "hiden"=>$hide)));
$GRID->encabezado("Cotizaciones", "FacFecha", array(
    false,true,false,true,true), "desc", 500);
$GRID->sql("select distinct FacID, FacID as id, FacDatos, FacFecha,CliNombre,
	FacTotal, (FacTotal - FacRecibio) as deuda, FacFormaPago, FacUsuario 
    from presupuestos inner join clientes on FacReceptor = CliID Where $datos->where ", "presupuestos");
$ventas = $GRID->mostrar();


echo DateHelper::datepicker(false);
echo "<h6>$datos->range</h6>";
echo $ventas; ?>

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
  		        'caption'      : 'Agregar Cotizaciones', 
  		        'buttonicon'   : 'ui-icon-plus', 
  		        'onClickButton': function()
  		        {
					window.location = "/Dashboard/Presupuesto";
  		        	//$.colorbox({escKey:false, overlayClose:false,iframe:true,href:"/Dashboard/Venta",width:"98%", height:"98%",onClosed:refrescar});  	  		       	
  		        },
  		        'position': 'first'
  		    });    	  							  	
		    add_button = true;		   
	  	}  	
	  	$(".box").colorbox({iframe:true, width:"98%", height:"98%", onClosed:refrescar});  	  
	  	
	  });
	
    $(".box").colorbox({iframe:true, width:"98%", height:"98%"});  	
	calendario();
	
});


function refrescar()
{
	$("#list1").trigger("reloadGrid", [{current:true}]);
}
</script>
