<?php

use App\Forms\Users;


/**
 *
 * @version v2022_1
 *         
 * @author Martin Mata
 *        
 */
@session_start();
global $params;

echo Users::login();
?>

<script type="module" src="/Dashboard/js/Form/post.js"></script>
<script type="module" src="/Dashboard/js/Form/validar.js"></script>
<script type="module" src="/Dashboard/js/Form/forma.js"></script>


<script type="module">
import {Form} from "/Dashboard/js/Form/forma.js";

var Forma = new Form(
		$("#usuarioForma"), //forma
		$('#submitusuarioForma'),//submit button
		"/Dashboard/Ajax/Controller.php", //controller
		"Login/login", //accion controller
		"Login...", //mensaje al terminar
		redirecciona // callback on success.
	);

$(document).ready(function()
{	
	$("#usuarioForma").on('submit', 
		function(event){Forma.handleSubmit(event)}); //Asigna submit a Forma
	$(document).on("change",".valida", 
		function(){Forma.iniciaValidacion($(this))}); //Asigna change a input 	
});

function redirecciona(respuesta)
{						
	location.replace(respuesta);	
} 
</script>