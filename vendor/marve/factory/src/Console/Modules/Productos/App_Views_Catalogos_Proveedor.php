<?php


/**
 *
 * @version v2023_1
 *         
 * @author Martin Mata
 *        
 */

use App\Forms\Proveedores as FormsProveedores;
use App\Models\Catalogos\Ajustes;
use App\Models\Catalogos\Proveedores;
use Marve\Ela\Core\CurrentUser;
use Marve\Ela\Core\Session;


global $params;


$PROVEEDOR = new Proveedores(CurrentUser::getDb());

if(isset($params["ProvID"]))
{
    $proveedor = $PROVEEDOR->get($params["ProvID"], "ProvID");
    $proveedor_json = json_encode($proveedor);   
}

//echo "<h5 class='text-center'>Datos del Proveedor</h5><hr>";
echo FormsProveedores::form();

?>

<script src='/Dashboard/js/domicilios.js?=1'></script>
<script src='//domicilio.gposanmiguel.com/cfdi4-json.js'></script>	

<script type="module" src="/Dashboard/js/Form/post.js"></script>
<script type="module" src="/Dashboard/js/Form/validar.js?v1"></script>
<script type="module" src="/Dashboard/js/Form/forma.js"></script>


<script type="module">
import {Form} from "/Dashboard/js/Form/forma.js";

Forma = new Form(
		$("#proveedorForma"), //forma
		$('#submitproveedorForma'),//submit button
		"/Dashboard/Ajax/Controller.php", //controller
		"Proveedor/store", //accion controller
		"Proveedore Agregado...", //mensaje al terminar
		refrescar
	);

$(document).ready(function()
{
	obtenerEstados("MEX");    	
	obtenerRegimens();
	$("#proveedorForma").on('submit', function(event)
	{                      
		$("#CliMunicipio2").val($("#CliMunicipio").find('option:selected').text());
		$("#CliColonia2").val($("#CliColonia").find('option:selected').text());  
		Forma.handleSubmit(event);
	}); //Asigna submit a Forma
	
	$(document).on("change",".valida", 
	function(){Forma.handleValidation($(this))}); //Asigna change a input 	

	<?php 
	if(isset($proveedor_json))
	{
		//Forma/filler.js
		echo "filler($proveedor_json,'proveedor');";
	}
	?>	
	
});

function refrescar(respuesta)
{		    
	self.close();
	parent.$.colorbox.close();
	parent.refrescarProveedores(respuesta.id);	    	
}
</script>
