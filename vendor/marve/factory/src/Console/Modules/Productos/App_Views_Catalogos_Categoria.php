<?php


/**
 *
 * @version v2022_1
 *         
 * @author Martin Mata
 *        
 */

use App\Forms\Categorias as FormsCategorias;
use App\Models\Catalogos\Ajustes;
use App\Models\Catalogos\Categorias;
use Marve\Ela\Core\CurrentUser;
use Marve\Ela\Core\Session;

global $params;


$CATEGORIA = new Categorias(CurrentUser::getDb());
$AJUSTES = new Ajustes(CurrentUser::getDb());

$url = $AJUSTES->get("Nube","AjuNombre")->AjuValor;

echo FormsCategorias::form();

?>

<script type="module" src="/Dashboard/js/Form/post.js"></script>
<script type="module" src="/Dashboard/js/Form/validar.js?v1"></script>
<script type="module" src="/Dashboard/js/Form/forma.js"></script>


<script type="module">
import {Form} from "/Dashboard/js/Form/forma.js";

Forma = new Form(
		$("#categoriaForma"), //forma
		$('#submitcategoriaForma'),//submit button
		"/Dashboard/Ajax/Controller.php", //controller
		"Categoria/store", //accion controller
		"Categoria Agregada...", //mensaje al terminar
		refrescar, // callback onsuccess.
		<?php echo ($url == 0)?"":"\"$url\" ,\"".CurrentUser::getCredenciales()."\"";?> 
	);

$(document).ready(function()
{	
	$("#categoriaForma").on('submit', function(event)
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
		parent.refrescarCategorias(respuesta.id);	    	
	}

</script>
