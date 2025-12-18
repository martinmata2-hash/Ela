<?php



/**
 *
 * @version v2022_1
 *         
 * @author Martin Mata
 *        
 */

use App\Forms\Categorias;

global $params;

echo Categorias::MarcasForm();    


?>


<script type="module" src="/Dashboard/js/Form/post.js"></script>
<script type="module" src="/Dashboard/js/Form/validar.js?v1"></script>
<script type="module" src="/Dashboard/js/Form/forma.js"></script>


<script type="module">
import {Form} from "/Dashboard/js/Form/forma.js";

var Forma = new Form(
		$("#marcasForma"), //forma
		$('#submitmarcasForma'),//submit button
		"/Dashboard/Ajax/Controller.php", //controller
		"Marcas/store/MarID", //accion controller
		"Marca Agregada...", //mensaje al terminar
		refrescar
	);

$(document).ready(function()
{	
	$("#marcasForma").on('submit', function(event)
	{                      		
		Forma.handleSubmit(event);
	}); //Asigna submit a Forma
	
	$(document).on("change",".valida", 
	function(){Forma.handleValidation($(this))}); //Asigna change a input 	

	
	
});

	function refrescar(respuesta)
	{		            
		self.close();
		parent.$.colorbox.close();
		parent.refrescarMarcas(respuesta.id);
	    	
	}

</script>
