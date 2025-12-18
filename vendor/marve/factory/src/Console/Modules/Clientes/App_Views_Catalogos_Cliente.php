<?php

/**
 *
 * @version v2022_1
 *         
 * @author Martin Mata
 *        
 */

use App\Forms\Clientes as FormsClientes;
use App\Models\Catalogos\Ajustes;
use App\Models\Catalogos\Clientes;
use Marve\Ela\Core\CurrentUser;

global $inicio, $params;


$CLIENTE = new Clientes(CurrentUser::getDb());

if(isset($params["CliID"]))
{
    $cliente = $CLIENTE->get($params["CliID"], "CliID");
    $cliente_json = json_encode($cliente);   
}

echo FormsClientes::form();

?>

<script src='/Dashboard/js/domicilios.js?=1'></script>
<script src='//domicilio.gposanmiguel.com/cfdi4-json.js'></script>		

<script type="module" src="/Dashboard/js/Form/post.js"></script> 
<script type="module" src="/Dashboard/js/Form/validar.js?v1"></script>
<script type="module" src="/Dashboard/js/Form/forma.js"></script>


<script type="module">
import {Form} from "/Dashboard/js/Form/forma.js";

	Forma = new Form(
		$("#clienteForma"), //forma
		$('#submitclienteForma'),//submit button
		"/Dashboard/Ajax/Controller.php", //controller
		"Cliente/store", //accion controller
		"Cliente Agregado...", //mensaje al terminar
		refrescar
	);

$(document).ready(function()
{	
    obtenerEstados("MEX");
    obtenerRegimens();    

	$("#clienteForma").on('submit', 
		function(event)
        {
            $("#CliMunicipio2").val($("#CliMunicipio").find('option:selected').text());
			$("#CliColonia2").val($("#CliColonia").find('option:selected').text());		
			$("#CliRazon").val($("#CliNombre").val());
			
            
			Forma.handleSubmit(event);
        }); //Asigna submit a Forma
	
		$(document).on("change",".valida", 
		function(){Forma.handleValidation($(this))}); //Asigna change a input 	

		<?php 
		if(isset($cliente_json))
		{
			//Forma/filler.js
			echo "filler($cliente_json,'cliente');";
		}
		?>
});
		
	//$("#refrescarRutas").click(function(){refrescarTienda(0);});		
			
	function refrescar(respuesta)
	{	
		self.close();
	    parent.$.colorbox.close();
	    $("#clienteForma").trigger("reset");
		parent.refrescarCliente(respuesta);															    		
	}

</script>
