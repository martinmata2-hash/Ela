<?php

use App\Grids\Compras;
use Marve\Ela\Core\CurrentUser;
use Marve\Ela\Core\DotEnv;
use Marve\Ela\Grid\Datagrid;
use Marve\Ela\MySql\DateHelper;



$AUXILIAR = new DateHelper();

if (isset($_GET["datefrom"]) && isset($_GET["dateto"]))
{
    $datos = $AUXILIAR->range($_GET["datefrom"], $_GET["dateto"], "FacFecha");
}
else
{
    $datos = $AUXILIAR->thisMonth("FacFecha");    
}

$edit = CurrentUser::isAdmin();

$GRID = new Datagrid();
$GRID->inicio(CurrentUser::getDb());
$usuarios = $GRID->g->get_dropdown_values("select distinct UsuID as k, UsuNombre as v from ".DotEnv::getDB().".usuarios where UsuActivo = 1");

$estado = "0:Creada; 3:Cerrada";
$link = "/Dashboard/Salida/{FacID}";
$ticket ="<a class='btn btn-primary box' href='/Dashboard/Imprimir-Salida/{FacID}'>Ticket</a>";
$GRID->campos(Compras::grid(array("editar" => $edit, "link" => $link,"options" => "'_blank'","status" => $estado,
    "usuarios"=>$usuarios,"imprimir"=>"$ticket", "proveedor"=>"CliNombre")));
$GRID->encabezado("Salidas", "FacID", array(false,true,false,true,true), "desc", 500);
$GRID->sql("select distinct c.*, FacID as id, CliNombre from salidas c 
    inner join clientes on CliID = FacEmisor where $datos->where group by FacID ", "salidas");
$compras = $GRID->mostrar();

function enviar($data)
{
    return "<a class='box btn btn-warning small' href='/Dashboard/Pdf-Salidas/".$data["FacID"]."' title='Imprimir'><i class='fas fa-file-pdf'></i></a>";
    /*    
    $e = $data["FacEstado"];
    if ($e == 1)
    {
        return "<a class='box btn btn-warning' href='/Dashboard/Email-Compras/".$data["FacID"]."' title='Enviar Email'><i class='fas fa-envelope'></i></a> "
            ." <a class='box btn btn-warning' href='/Dashboard/Pdf-Compras/".$data["FacID"]."' title='Imprimir'><i class='fas fa-file-pdf'></i></a>";
    }
    elseif($e == 2)
    {
        return "<a class='box btn btn-primary' href='/Dashboard/Recibir-Compras/".$data["FacID"]."/1' title='Aprovado'><i class='fas fa-check'></i></a> "
            ." <a class='box btn btn-warning' href='/Dashboard/Pdf-Compras/".$data["FacID"]."' title='Imprimir'><i class='fas fa-file-pdf'></i></a>";
    }
    elseif($e == 3)
    {
        return "<a class='box btn btn-warning' href='/Dashboard/Pdf-Cotizaciones/".$data["FacID"]."' title='Imprimir'><i class='fas fa-file-pdf'></i></a>";
    }
    */
}

echo $AUXILIAR->datepicker();
echo $datos->rango;

 
 echo $compras;?>

<input id='CSRF' type='hidden' value='<?php echo CurrentUser::getCsrf(); ?>' /> 

<script> 
var add_button = false;

var agregarCompra; 

$(document).ready(function()
{
   
	$(document).ajaxComplete(function( event,request, settings )
	  {
	  	if(!add_button)
	  	{
    	  	$('#list1').jqGrid('navButtonAdd', '#list1_pager_left', 
  		    {  		       
  		        'caption'      : 'Agregar Salida', 
  		        'buttonicon'   : 'ui-icon-plus', 
  		        'onClickButton': function()
  		        {
					window.open("/Dashboard/Salida","_self");
  		        	//$.colorbox({escKey:false, overlayClose:false,iframe:true,href:"/Dashboard/Compra",width:"98%", height:"98%",onClosed:refrescar});   		             		    		
  		        },
  		        'position': 'first'
  		    });    	  	
			
			  	
		    add_button = true;
		    //$(".ui-jqgrid-titlebar-close").trigger("click");
		    //$("#actividad-toggle").trigger("click");
	  	}  	
	  	$(".box").colorbox({escKey:false, overlayClose:false,iframe:true, width:"98%", height:"98%", onClosed:refrescar});  	  
	  	
	  });
	
	$(".box").colorbox({escKey:false, overlayClose:false,iframe:true, width:"98%", height:"98%",onClosed:refrescar});  
	//$(document).on("click",".actividad", function(){ $("#actividad").show("slow").focus();});

	$("#actividad-toggle").click(function(){$("#actividad").toggle("slow");});
	calendario();
	
});
function refrescar(registro)
{              
	$("#list1").trigger("reloadGrid", [{current:true}]);	
								
}


</script>

