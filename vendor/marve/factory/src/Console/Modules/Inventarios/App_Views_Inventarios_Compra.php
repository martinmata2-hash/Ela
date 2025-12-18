<?php

use App\Forms\Compras as FormsCompras;
use App\Models\Inventarios\Compras;
use Marve\Ela\Core\CurrentUser;
use Marve\Ela\Core\Generic;

global $params;

$CLIENTE = new Generic(CurrentUser::getDb(), "clientes");
$COMPRAS = new Compras(CurrentUser::getDb());

$compra = new stdClass();

if(isset($params["FacID"]))
{    
    $compra = $COMPRAS->get($params["FacID"], "FacID");
    $compra->FacNota = str_replace(array('\r\n', '\n\r', '\r', '\n'),"\n",$compra->FacNota);    
}


?>


<div class="mt-0 d-none d-md-block">  
    <button class="btn btn-outline-success me-4" type="button">Cliente &emsp; shift &larr; </button>
    <button class="btn btn-outline-success me-4" type="button">Pagar &emsp; shift &darr; </button>    
    <button class="btn btn-outline-success me-4" type="button">Codigo &emsp; shift &rarr; </button>
    <button class="btn btn-outline-success me-4" type="button">Buscar &emsp; shift &uarr; </button>    
    <button class="btn btn-outline-success me-4" type="button">Archivar &emsp; shift Enter </button>
    <button onclick="window.location = '/Dashboard/Compras'" class="btn btn-outline-primary me-6" type="button">Menu</button>  
</div>
<hr/>

<div class='row gx-5 justify-content-center'>
    
        <div class='row'>
            <?php
            echo FormsCompras::encabezado($compra);
            echo FormsCompras::tablaProductos(($compra->Detalles)??"");
            unset($compra->Detalles);
            //$compra_json = json_encode($compra, JSON_FORCE_OBJECT);
            //echo FormsCompras::pagos();
            ?>


            <div class='col-md-12 col-xl-6'>
                <!-- Submit Button-->
                <div class='button-group text-center'>
                    <button type="button" class='btn btn-primary archivar' id='submitButtonCompra'>
                        Archivar</button>
                    <button type="button" class='btn btn-danger' id='resetButtonCompra'>
                        Limpiar</button>
                </div>
            </div>
        </div>       
</div>



<!--             Modulos             -->
<script type="module" src="/Dashboard/js/Form/post.js"></script>
<script type="module" src="/Dashboard/js/Form/validar.js"></script>
<script type="module" src='/Dashboard/js/Pos/clases/poscompra.js?v1'></script>
<script type="module" src='/Dashboard/js/Pos/clases/compra.js?v1'></script>   


<!-- modulos globales  -->

<script>
	var CompraObject;	
</script>

<script type="module">
import { Compra }from "/Dashboard/js/Pos/clases/compra.js";
CompraObject = new Compra();
import {Form} from "/Dashboard/js/Form/forma.js";

var Forma = new Form(
		$("#compraForma"), //forma
		$('#submitcompraForma'),//submit button
		"/Dashboard/Ajax/Controller.php", //controller
		"Compra/store", //accion controller
		"Compra...", //mensaje al terminar
		refrescar // callback on success.
	);


   
    $(document).ready(function() 
    {        
        $(document).on('click keyup',function(event){ CompraObject.calcular();});
        $(document).on("change",".valida", function(){Forma.handleValidation($(this))});
    });
</script>


<script>
    $(document).ready(function() 
    {  
	/*****************shorcuts***********/
	$(document).on('keydown', map);	

        function map(e)
        {
            if(e.shiftKey)
            {			
                if(e.code == 'ArrowLeft')
                    $("#FacEmisor").focus();
                else if(e.code == 'ArrowRight')
                    $("#codigo").focus();
                else if(e.code == 'ArrowDown')
                    $("#descuento").focus().select();
                else if(e.code == 'ArrowUp')
                {				
                    $("#buscarProducto").
                        attr("href", '/Dashboard/Listas-Productos/1?list1_ProDescripcion='+$("#codigo").val()).
                        trigger('click');
                }			
            }
        }	

        /**************************************** */
        $("#codigo").focus();       

        $("#resetButtonCompra").click(function(){reset();})

        $("#lista_productos tbody").change(function()
        {            
            if($(this).length > 0)                
            {
                $("#FacEmisor").prop("disabled", "disabled");
                $("#pagos").show("slow");
                $("#codigo").focus();
            }
            else
            {
                $("#FacEmisor").prop("disabled", false);
                $("#pagos").hide("slow");
                $("#codigo").focus();
            }            
        });

        $(document).on("click", ".cut", function()
        {
            $(this).parent().parent().remove();
            $("#lista_productos tbody").change();
        });


        $("#codigo").keydown(function(e)
	    {
			var codigo = " ";
		    var cantidad = 1;
			var key = window.event ? e.keyCode : e.which;
			if (key == "9" || key == "13")
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
		 			var data = 
					{
						accion:"Compra/codigo",
						data:{codigo:codigo,cantidad:cantidad },
						token:$("#CSRF").val()
					}
                    AjaxPeticiones.request("/Dashboard/Ajax/Controller.php",data,agregaProducto);            					
	      		}          	
			}
		});                           
       

        $("#submitButtonCompra").click(function()
        {            	
            if(!verificaCompra())
               $("#submitButtonCompra").notify("verifica los datos","error");
            else
            {
                var compra =CompraObject.obtener();
                $("#submitButtonCompra").prop("disabled",true);	                
                var data = 
                {
                    accion:'Compra/store',		
                    data:compra,
                    token:$("#CSRF").val()
                };	
                AjaxPeticiones.request("/Dashboard/Ajax/Controller.php",data,refrescar,$("#submitButtonCompra"));            					                
                
            }

        });              

        function agregaProducto(tr)
	    {					    	
	    	var ok = false;
            var emptyColumn;
	    	if(tr !== 0)
	    	{			 		    
                emptyColumn = tr;		   				    			    		
	    		var ID = $(emptyColumn).find(".ProID").val();
	    		var cantidad = $(emptyColumn).find(".cantidad").val();	
	    		
	    		$("#lista_productos tbody tr").find(".ProID").each(function()
	    		{
	    			if($(this).val() == ID)
	    			{
	    				ok = true;
	    				var cantidadanterior = $(this).closest("tr").find(".cantidad").val();
	    				$(this).closest("tr").find(".cantidad").val(Number(cantidad) + Number(cantidadanterior)).click();				
	    			}
	    		});
	    		
	    		if(!ok)
	    		{
	            	$('#lista_productos tbody').append(emptyColumn);	 		   						
	            	$(emptyColumn).find(".cantidad").click();	 		   						        								        	
	    		}	
                $('#lista_productos tbody').change();
	    		$("#codigo").val("");
	    		$("#codigo").focus();			                
	    	}
	    	                   	    	    	    
	    }

        function verificaCompra()
        {
            var valido = true;                                                                                               
            return valido;            
        }

      
    });
    
   
    
    function refrescar(respuesta)
    {
   
        location.reload();
        /*
        $("#lista_productos tbody tr").remove();
        $("input[type='number']").val(0);
        $("#FacReceptor").prop("disabled", false);
        $("#FacReceptor").val(1);
        $("#FacMedico").val(1);
        $("#pagos").hide("slow");
        $("#panelProducto").html("");
        $("#codigo").focus();
        $("#cambio").val("0.00");¨
        */
    }
</script>