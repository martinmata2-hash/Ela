<?php

use App\Forms\Pagos as FormsPagos;
use App\Models\Pos\Pagos;
use App\Models\Reportes\Flujos;
use Marve\Ela\Core\CurrentUser;

$FLUJO = new Flujos(CurrentUser::getDb());
$PAGO = new Pagos(CurrentUser::getDb());

echo FormsPagos::form();
?>

<style>
	.seleccionado
	{
		background-color: greenyellow;
	}
</style>
<div class='row'>
<div id="info" class='text-center  col-md-6'>

</div>
<div id="historialpagos" class='text-center  col-md-6'>

</div>
</div>
<hr class='clear'>
<h3>Lista General</h3>
<div class='row'>
<div id='deudas' class="col-md-6">
	<table class="table" id='listaadeudos'>
		<thead>
			<tr>
				<th>Nombre</th><th>Adeudo</th>
			</tr>
		</thead>
		<tbody>

		</tbody>
	</table>
</div>
<div id='detalles' class="col-md-6">

</div>


<script type="module" src="/Dashboard/js/Form/post.js"></script> 
<script type="module" src="/Dashboard/js/Form/validar.js?v1"></script>
<script type="module" src="/Dashboard/js/Form/forma.js"></script>


<script type="module">
import {Form} from "/Dashboard/js/Form/forma.js";

	Forma = new Form(
		$("#pagosForma"), //forma
		$('#submitpagosForma'),//submit button
		"/Dashboard/Ajax/Controller.php", //controller
		"Pago/aCliente", //accion controller
		"Pago Agregado...", //mensaje al terminar
		refrescar2
	);

$(document).ready(function()
{	    
	$("#pagosForma").on('submit', function(event){Forma.handleSubmit(event);}); //Asigna submit a Forma
	$(document).on("change",".valida", function(){Forma.handleValidation($(this))}); //Asigna change a input 			
});
</script>
<script>
$(document).ready(function()
{
	obteneradeudos(0,20);

	$("#cliente").change(function()
    {
        var form_data = 
		{
			accion:'Pago/cliente',		
			data:{cliente:$("#cliente").val()},
			token:$("#CSRF").val()
		};	
        AjaxPeticiones.request("/Dashboard/Ajax/Controller.php",form_data,mostrarcliente);   	

    });
	
	
	$(document).on("click",".pagodetalle", function()
	{
		$(".pagodetalle").removeClass("seleccionado");
		$(this).addClass("seleccionado");
		var CliID = $(this).attr("id");
		var form_data = 
		{
			accion:'Cliente/pagos',		
			data:{cliente:CliID},
			token:$("#CSRF").val()
		};
				
        
	});
	
	$(document).on("click",".clientedetalle", function()
	{
		var CliID = $(this).attr("id").substring(1);
		var form_data = 
		{
			accion:'Cliente/pagos',		
			data:{cliente:CliID},
			token:$("#CSRF").val()
		};
				
       AjaxPeticiones.request("/Dashboard/Ajax/Controller.php",form_data,mostrarpagos2);   
	});

	function obteneradeudos(limite1, limite2)
	{
		var form_data = 
		{
			accion:'Pago/adeudos',		
			data:{limite1:limite1,limite2:limite2},
			token:$("#CSRF").val()
		};
		AjaxPeticiones.request("/Dashboard/Ajax/Controller.php",form_data,mostraradeudo);   	
        
	}
	function mostrarpagos(respuesta)
	{
		$("#detalles").html(respuesta);
	}

	function mostrarpagos2(respuesta)
	{
		$("#historialpagos").html(respuesta);
	}

	function mostraradeudo(respuesta)
	{
		$("#listaadeudos tbody").append(respuesta);
	}   
		
	function mostrarcliente(respuesta)
	{
		$("#info").html(respuesta);
	}

	
});

function refrescar2(respuesta)
	{				
		 $.colorbox({
            href:"/Dashboard/Imprimir-PagoC/"+respuesta.cliente+"?cantidad="+respuesta.cantidad,
            iframe: true,
            width: "50%",
            height: "50%",
			escKey: false,
            onClosed: pagina_refrescar       
        });     		
	}
</script>
