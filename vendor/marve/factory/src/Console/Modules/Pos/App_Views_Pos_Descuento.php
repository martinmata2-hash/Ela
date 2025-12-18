<?php

use App\Forms\Descuentos as FormsDescuentos;
use App\Models\Pos\Descuentos;

/**
 *
 * @version v2022_1
 *         
 * @author Martin Mata
 *        
 */


global $params;


$DESCUENTOS = new Descuentos();

if (isset($params["DesID"])) {
    $descuento = $DESCUENTOS->get($params["DesID"], "DesID");
    $descuento_json = json_encode($descuento);
}

echo "<h5 class='text-center'>Datos de Promoción o Descuento </h5><hr>";
echo FormsDescuentos::form();
?>

<script type="module" src="/Dashboard/js/Form/post.js"></script>
<script type="module" src="/Dashboard/js/Form/validar.js"></script>
<script type="module" src="/Dashboard/js/Form/forma.js"></script>


<script type="module">
import {Form} from "/Dashboard/js/Form/forma.js";

var Forma = new Form(
		$("#descuentoForm"), //forma
		$('#submitButtonPromosion'),//submit button
		"/Dashboard/Ajax/Controller.php", //controller
		"Descuento/store", //accion controller
		"Descuento...", //mensaje al terminar
		refrescar // callback on success.
	);

$(document).ready(function()
{	
	$("#descuentoForm").on('submit', 
		function(event){Forma.handleSubmit(event)}); //Asigna submit a Forma
	//$(document).on("change",".valida", 
	//	function(){Forma.handleValidation($(this))}); //Asigna change a input 	
}); 
</script>
<script>
    $(document).ready(function() {

        $("[name='DesTipo']").click(function() {
            if ($(this).is(":checked")) {
                if ($(this).val() == 0) {
                    $(".promosion").hide("slow");
                    $(".descuento").show("slow");
                } else if ($(this).val() == 1) {
                    $(".promosion").show("slow");
                    $(".descuento").hide("slow");
                }
            }
        });

        $("[name='DesObjetivo']").click(function() {
            if ($(this).is(":checked")) {
                if ($(this).val() == "Producto") {
                    $(".categoria").hide("slow");
                    $(".subcat").hide("slow");
                    $(".producto").show("slow");
                } else if ($(this).val() == "Categoria") {

                    $(".categoria").show("slow");
                    $(".subcat").hide("slow");
                    $(".producto").hide("slow");
                } else if ($(this).val() == "SubCat") {

                    $(".categoria").hide("slow");
                    $(".subcat").show("slow");
                    $(".producto").hide("slow");
                }
            }
        });             

       

        $("[name='Tipo']").trigger("click");
        $("[name='DesTipo']").trigger("click");
        $("#DesTipo0").prop("checked", true).click().change();
        $("#DesTipo2").prop("checked", true).click().change();
        calendario();
    });

     function refrescar(respuesta) {
            self.close();
            parent.$.colorbox.close();
            $("#descuentoForm").trigger("reset");
            parent.refrescar(respuesta);
        }

</script>