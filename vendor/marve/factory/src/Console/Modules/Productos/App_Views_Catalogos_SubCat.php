<?php



/**
 *
 * @version v2022_1
 *         
 * @author Martin Mata
 *        
 */

use App\Forms\Categorias;
use Marve\Ela\Core\CurrentUser;
use Marve\Ela\Core\Generic;

global $params;

	
$SUBCAT = new Generic(CurrentUser::getDb(),"subcat");

echo Categorias::SubCatForm();

?>


<script type="module" src="/Dashboard/js/Form/post.js"></script>
<script type="module" src="/Dashboard/js/Form/validar.js?v1"></script>
<script type="module" src="/Dashboard/js/Form/forma.js"></script>


<script type="module">
import {Form} from "/Dashboard/js/Form/forma.js";

var Forma = new Form(
		$("#subcatForma"), //forma
		$('#submitsubcatForma'),//submit button
		"/Dashboard/Ajax/Controller.php", //controller
		"Subcat/store/SubID", //accion controller
		"SubCat Agregada...", //mensaje al terminar
		refrescar
	);

$(document).ready(function()
{	
	$("#subcatForma").on('submit', function(event)
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
		parent.refrescarSubCat(respuesta.id);
	    	
	}

</script>
