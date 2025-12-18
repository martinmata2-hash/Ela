<?php

use App\Forms\Inventarios as FormInventarios;
use App\Models\Catalogos\Inventarios;
use Marve\Ela\Core\CurrentUser;
use Marve\Ela\Core\Generic;

/**
 *
 * @version v2022_1
 *         
 * @author Martin Mata
 *        
 */


global $params;


$INVENTARIO = new Inventarios();
$PERDIDAS = new Generic(CurrentUser::getDb(),"perdidas");
echo FormInventarios::form();
?>

<script>

$(document).ready(function()
{
	$("#Categorias").change(function(event)
	{						
		var form_data = 
		{
			accion:'Producto/subcat',		
			data:{condicion:$("#Categorias").val()},
			token:$("#CSRF").val()			
		};
		
		return AjaxPeticiones.fillSelect("/Dashboard/Ajax/Controller.php",form_data,$("#Subcat"));	

		soloCategoria($("#Categorias").val());
	});



    $("#Subcat").change(function(event)
	{							
		var form_data = 
		{
			accion:'Producto/productos',		
			data:{subcategoria:$("#Subcat").val(),
                categoria:$("#Categorias").val()},
			token:$("#CSRF").val()			
		};
		
		archivar(INICIO+"Ajax/Controller.php",form_data, 
			null, <?php echo POS_SUCCESS;?>, 
			"OK", productos);						
	});

    $("#codigo").keydown(function(e)
    {
		var codigo = " ";	    
		var cantidad = 0;
		var key = window.event ? e.keyCode : e.which;
		if (key == 9 || key == 13)
	    {
	       	if($(this).val().length > 0)
	       	{
	 			e.preventDefault();                
				 if($(this).val().indexOf("*") > 0)
	 			{
				  	var partes = $(this).val().split("*");
				  	codigo = partes[1];
				  	cantidad = partes[0];
	 			}
	 			else
					codigo = $(this).val();
	 			$("#"+codigo).prop("checked", true)
                var form_data = 
				{
					accion:"Inventario/codigo",
					data:{codigo:codigo,cantidad:cantidad},
					token:$("#CSRF").val()
				}
			
				 AjaxPeticiones.request("/Dashboard/Ajax/Controller.php",form_data,agregaProducto);    
	 				 			
      		}          	
		}
	});   

	$(document).on("keydown", ".cantidad", function(e)
	{
		var key = window.event ? e.keyCode : e.which;
		if (key == 9 || key == 13)
	    {
			$("#codigo").focus();
		}
	});

	$("#imprimir").click(function()
	{
		//loading($("#imprimir"),true);	        	 	
		$('input[type=submit]').attr('disabled', 'disabled');	
		var index = 0;
		var lista = {};
		lista.Detalles = [];
		$("#listaProductos table tbody tr").each(function()
		{
			index++;
			var detalle = {};
			detalle.codigo = $(this).find(" td:nth-child(2)").text();
			detalle.descripcion = $(this).find(" td:nth-child(3)").text();
			detalle.cantidad = $(this).find(" td:nth-child(4)").text();
			lista.Detalles.push(detalle);
			if(index > 100)
				return false;
		});

		$.redirect("/Dashboard/InventariosPDF",{"etiquetas":lista},"POST","_blank");
		/*
		var form_data = 
        {
            accion:"Producto/imprimirInv",
            data:lista,
            token:$("#CSRF").val()
        }
    
        archivar(INICIO+"Ajax/Controller.php",form_data,null, 
        <?php echo POS_SUCCESS;?>, "OK", refrescar);
		*/

	});

    $("#submitinventarioForma").click(function()
    {
        event.preventDefault();		 	
        var perdida = {};
		perdida = [];
		$("#inventory tbody tr").each(function()
		{
			var detalle = {};			 			                            
			detalle.PerProducto = $(this).find(".ProID").val();
			detalle.PerRazon = $("#RazonGeneral").val();						
			detalle.PerCantidad = $(this).find(".cantidad").val();		
			detalle.PerExistencia = $(this).find(".importe").val();
			detalle.PerUsuario = <?php echo CurrentUser::getId();?>;			
			detalle.TiendaID = 1;
			perdida.push(detalle);
		});	 	

        var form_data = 
        {
            accion:"Inventario/perdida",
            data:perdida,
            token:$("#CSRF").val()
        }
		 AjaxPeticiones.request("/Dashboard/Ajax/Controller.php",form_data,refrescar,$("#submitinventarioForma"));      

    });

		
    function refrescarSub(respuesta)
    {    
        $("#Subcat").find('option')
        .remove()
        .end()
        .append('<option>selecciona</option>'+respuesta);
    }

    function productos(respuesta)
    {
        $("#listaProductos").html(respuesta);
    }

    function agregaProducto(respuesta)
    {
        var ok = false;
    	if(respuesta.status == <?php echo POS_SUCCESS?>)
    	{			 	
    		var emptyColumn = document.createElement('tr');
    		emptyColumn.innerHTML = respuesta.html; 	   			
            var ID = $(emptyColumn).find(".ProID").text(); 			
 			var ok = false; 				 		
			$("#inventory tbody tr").find(".ProID").each(function()
			{		 		 		   				
				if($(this).val() == ID)
				{
					ok = true;									
					$("#codigo").val("");
					$(this).parent().parent().find(".cantidad").select().focus();		
				}
			});
			if(!ok)
            {
                document.querySelector('#inventory tbody').appendChild(emptyColumn);
				$("#codigo").val("");
				$(emptyColumn).find(".cantidad").select().focus();                                			 								
            }    		    		    	            
    	}
    	    			
    }

    function refrescar(respuesta)
    {
        $("#listaProductos").html("");
        $("#inventory tbody tr").remove();
    }

	function soloCategoria(cat)
	{
					        	 	
		$('input[type=submit]').attr('disabled', 'disabled');						
		var form_data = 
		{
			accion:'Producto/categoria',		
			data:{subcategoria:$("#Subcat").val(),
                categoria:$("#Categorias").val()},
			token:$("#CSRF").val()			
		};
		
		archivar(INICIO+"Ajax/Controller.php",form_data, 
			null, <?php echo POS_SUCCESS;?>, 
			"OK", productos);						
	
	}

});

</script>
