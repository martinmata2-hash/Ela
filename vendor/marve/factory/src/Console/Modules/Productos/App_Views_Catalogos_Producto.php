<?php

use App\Forms\Productos as FormsProductos;
use App\Models\Catalogos\Ajustes;
use App\Models\Catalogos\Productos;
use Marve\Ela\Core\CurrentUser;

/**
 *
 * @version v2023_1
 *         
 * @author Martin Mata
 *        
 */


global $params;


$PRODUCTOS = new Productos(CurrentUser::getDb());
$AJUSTES = new Ajustes(CurrentUser::getDb());

if(isset($params["ProID"]))
{
    $producto = $PRODUCTOS->get($params["ProID"], "ProID");
    $producto_json = json_encode($producto);    
}

?>
<style>
	input[type="checkbox"] {
		transform: scale(2);
	}
</style>
<div class='row gx-5 justify-content-center'>

<?php


echo FormsProductos::form(array("admin"=>CurrentUser::isAdmin()));

?>

<script type="module">
import { Form } from "/Dashboard/js/Form/forma.js";

 	Forma = new Form(
		$("#productoForma"), //forma
		$('#submitproductoForma'),//submit button
		"/Dashboard/Ajax/Controller.php", //controller
		"Producto/store", //accion controller
		"Producto Agregado...", //mensaje al terminar
		refrescar
	);

</script>

<script>
$(document).ready(function()
{

	$("#productoForma").on('submit', function(event)
	{                        
		Forma.handleSubmit(event);
	}); //Asigna submit a Forma
	
	$(document).on("change",".valida", 
	function(){Forma.handleValidation($(this))}); //Asigna change a input 	

	<?php 
	if(isset($producto_json))
	{
		//Forma/filler.js
		echo "filler($producto_json,'producto');";
	}
	?>

	$("#ProCompra").change(function()
	{
		$(".porcentaje").trigger("change");
	});

	$(".porcentaje").change(function()
	{				
		$("#"+$(this).data('id')).val(($("#ProCompra").val() * (1+($(this).val()/100))).toFixed(2));
		$("#"+$(this).data('id')).val((Math.ceil($("#"+$(this).data('id')).val() * 2)/2).toFixed(2));
	});

	$(".precio").change(function()
	{
		$("#"+$(this).data('id')).val(((($(this).val()/($("#ProCompra").val())) - 1)*100).toFixed(3));		
	});
	
	$("#ProAntibiotico").click(function()
	{
		if($(this).is(":checked"))
			$("input[name='ProAntibiotico']").val(1);
		else
		$("input[name='ProAntibiotico']").val(0);
	});

	$("#ProPaquete").click(function()
	{
		if($(this).is(":checked"))
			$("input[name='ProPaquete']").val(1);
		else
			$("input[name='ProPaquete']").val(0);
	});		

	function mostrarProducto(respuesta)
	{
		var datos = JSON.parse(respuesta);
		filler(datos,'producto');		     
	}

});

function refrescar(respuesta)
{						
	$("#productosForma").trigger("reset");
	parent.refrescarProductos(respuesta);
	self.close();
	parent.$.colorbox.close();	    																		  
}
	
function refrescarProveedores(respuesta)
{
    var data = 
	{
		accion:'Proveedores/list/ProvID',		
		data:{name:"ProvRazon",id:"ProvID",selected:respuesta},
		token:$("#CSRF").val()
	};

	return AjaxPeticiones.fillSelect("/Dashboard/Ajax/Controller.php",data,$("#ProProveedor"));		
}

function refrescarCategorias(respuesta)
{
    var data = 
	{
		accion:'Categorias/list/CatID',		
		data:{name:"CatNombre",id:"CatID",selected:respuesta},
		token:$("#CSRF").val()
	};

	return AjaxPeticiones.fillSelect("/Dashboard/ajax/Controller.php",data,$("#ProCategoria"));			
}


function refrescarSubCat(respuesta)
{
    var data = 
	{
		accion:'Subcat/list/SubID',		
		data:{name:"SubNombre",id:"SubID",selected:respuesta},
		token:$("#CSRF").val()
	};
	
	return AjaxPeticiones.fillSelect("/Dashboard/ajax/Controller.php",data,$("#ProSubCat"));				
}

function refrescarMarcas(respuesta)
{
    var data = 
	{
		accion:'Marcas/list/MarID',		
		data:{name:"MarNombre",id:"MarID",selected:respuesta},
		token:$("#CSRF").val()
	};
	
	return AjaxPeticiones.fillSelect("/Dashboard/ajax/Controller.php",data,$("#ProMarca"));					
}

function refrescarLaboratorio(respuesta)
{
    var data = 
	{
		accion:'Laboratorios/list/LabID',		
		data:{name:"LabNombre",id:"LabID",selected:respuesta},
		token:$("#CSRF").val()
	};
	
	return AjaxPeticiones.fillSelect("/Dashboard/ajax/Controller.php",data,$("#ProLaboratorio"));					
}

</script> 
