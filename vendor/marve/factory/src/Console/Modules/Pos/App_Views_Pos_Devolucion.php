<?php

use App\Forms\Ventas as FormsVentas;
use App\Models\Catalogos\Ajustes;
use App\Models\Pos\Ventas;
use Marve\Ela\Core\CurrentUser;


@session_start();

global $params;

$VENTAS = new Ventas(CurrentUser::getDb());
$AJUSTES = new Ajustes(CurrentUser::getDb());

$venta = 0;
$readonly = false;
if(isset($params["FacID"]))
{
    $venta = $VENTAS->get($params["FacID"], "FacID");
    $venta->FacNota = str_replace(array('\r\n', '\n\r', '\r', '\n'),"\n",$venta->FacNota);    
    if($venta->FacEstado == 1)
        $readonly = true;
}
else
{
    die("Selecciona venta a devolver");
}


?>

<style>

    .readonly-red td
    {
        background-color: red !important; /* For IE */
        color: white !important; /* Optional: improves contrast */
        border: 1px solid darkred !important; /* Optional: adds definition */
    }       
</style>

<div class="mt-0 d-none d-md-block">  
    <button class="btn btn-outline-success me-4" type="button">Cliente &emsp; shift &larr; </button>
    <button class="btn btn-outline-success me-4" type="button">Pagar &emsp; shift &darr; </button>    
    <button class="btn btn-outline-success me-4" type="button">Codigo &emsp; shift &rarr; </button>
    <button class="btn btn-outline-success me-4" type="button">Buscar &emsp; shift &uarr; </button>    
    <button class="btn btn-outline-success me-4" type="button">Archivar &emsp; shift Enter </button>
    <button onclick="window.location = '/Dashboard/Ventas'" class="btn btn-outline-primary me-6" type="button">Menu</button>  
</div>
<hr/>
<h3 style="color: red;">DEVOLUCION <?php if($readonly) echo "CERRADA";?></h3>
<div class='row gx-5 justify-content-center'>
    <div class='col-lg-10 col-md-9'>
        <div class='row'>
            <?php
            echo FormsVentas::encabezado($venta);
            echo FormsVentas::tablaProductos(($venta->Detalles)??"");
            unset($venta->Detalles);
            $venta_json = json_encode($venta, JSON_FORCE_OBJECT);
            echo FormsVentas::pagos($venta);
            ?>


            <div class='col-lg-6 col-xl-6'>
                <!-- Submit Button-->
                 <?php if(!$readonly)
                 {?>
                <div class='button-group text-center'>
                    <button type="button" class='btn btn-primary archivar' id='submitButtonVenta'>
                        Archivar</button>                   
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class='col-lg-2 col-md-3 border border-primary'>           
        <h5 id='Cliente'>Cliente </h5>                            
        <h5 id='Credito'>0.00</h5>
        <!-- <h5 id='Puntos'>0</h5> -->
        <hr/>
        <div id="panelProducto"></div>
    </div>
</div>



<!--             Modulos             -->
<script type="module" src='/Dashboard/js/Pos/clases/detalleventas.js'></script>
<script type="module" src='/Dashboard/js/Pos/clases/posventa.js'></script>
<script type="module" src='/Dashboard/js/Pos/clases/venta.js'></script>   
<script type="text/javascript" src='/Dashboard/js/Pos/ventas.js'></script>   

<!-- modulos globales  -->

<script>
	var VentaObject;	
</script>

<script type="module">
import { Venta }from "/Dashboard/js/Pos/clases/venta.js";
VentaObject = new Venta();

</script>


<script>
    var Precio = 1;
    var Credito = 0.00;
    var Puntos = 0;
    var cambio = false;
    $(document).ready(function() 
    {
        $("#FacNota").val(`<?php echo $venta->FacNota?>`);
        $(document).on('click keyup',function(event)
        { 
            VentaObject.calcular();
            if(cambio)
            {
                cambio = false;
                $("#FacRecibio").keyup();                
            }
            });
            <?php 
    if(!$readonly)
            {?>       
       
        $("#resetButtonVenta").click(function(){reset();})
        // $("#FacRecibio").prop("readonly",true);
        $("#FacFormaPago").prop("disabled",true);

        $("#FacReceptor").prop("disabled",true);               

        $("#codigo").keydown(function(e)
	    {
			var codigo = " ";
		    var cantidad = -1;
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
						accion:"Venta/codigo",
						data:{precio:Precio,codigo:codigo,cantidad:cantidad,venta:true, cliente:$("#FacReceptor").val()},
						token:$("#CSRF").val()
					}
                    AjaxPeticiones.request("/Dashboard/Ajax/Controller.php",data,agregaProducto);            					
	      		}          	
			}
		});   

       $(document).on("change", ".cantidad", function()
        {   
            $(this).val(cantidadnegativa($(this).val()));
            var tr = $(this).parent().parent();
            var cantidad = $(this).val()*1;           
            var productos = 0;
		    var ID = $(this).closest("tr").find(".ProID").val();
   		    $("#lista_productos tbody tr").find(".ProID").each(function()
		    {	 		   				
	   		    if($(this).val() == ID)
	   		    {		   		
		   		    productos += $(this).closest("tr").find(".cantidad").val() * 1;
	   		    }
		    });
   		    if(productos < 0)
			   $(this).val(cantidad - productos);                        
        });

        function cantidadnegativa(numero)
        {//se asegura que solo se agreguen devoluciones
            return (numero > 0)?-numero:numero;
        }      

        $("#submitButtonVenta").click(function()
        {            	
            if(!verificaVenta())
               $("#submitButtonVenta").notify("verifica los datos","error");
            else
            {
                var venta =VentaObject.obtener();
                $("#submitButtonCompra").prop("disabled",true);	                
                var data = 
                {
                    accion:'Venta/store',		
                    data:venta,
                    token:$("#CSRF").val()
                };	
                AjaxPeticiones.request("/Dashboard/Ajax/Controller.php",data,reset,$("#submitButtonVenta"));            					                
                
            }

        });
             
        function agregaProducto(tr)
	    {					                
	    	var ok = false;
            var emptyColumn;
	    	if(tr.status == <?php echo POS_SUCCESS?>)
	    	{			 		    
                emptyColumn = tr.html.replace(/\n/g, '');		   				    			    		
	    		var ID = $(emptyColumn).find(".ProID").val();
	    		var cantidad = $(emptyColumn).find(".cantidad").val();	
                var precio = 0.00;
                var cantidadanterior = 0;
	    		var devolucion;
	    		$("#lista_productos tbody tr").find(".ProID").each(function()
	    		{
	    			if($(this).val() == ID)
	    			{
	    				 if(!ok)
                        {                             
                            ok = true;
                            devolucion = $(this).closest("tr").clone();
                            $(devolucion).find(".cantidad").val("-1"); 
                            cambio = true;
                            precio = $(this).closest("tr").find(".ProPrecio1").val();         
                            $(emptyColumn).find(".ProPrecio1").val(precio);	                           
                            cantidadanterior = Number($(this).closest("tr").find(".cantidad").val());                                  
                        }
                        else
                            cantidadanterior += Number($(this).closest("tr").find(".cantidad").val());				
	    			}
	    		});
	    		
	    		if(ok)
	    		{                                  
	            	$(emptyColumn).find(".ProPrecio1").val(precio);	                                            
                    $(emptyColumn).css("color","#ed6c6a"); 		   						
	            	$(emptyColumn).find(".cantidad").click();	 	
                    cantidadanterior += Number(cantidad);
                    if(cantidadanterior >= 0)
                    {      
                       $(devolucion).css("color","#ed6c6a");
                        $('#lista_productos tbody').append(devolucion);                        
                        $(emptyColumn).find(".cantidad").click();	 	
                    }	   
                   	   						        								        	
	    		}	
                $('#lista_productos tbody').change();
	    		$("#codigo").val("");
	    		$("#codigo").focus();	
                
	    	}
	    	                   	    	    	    
	    }

        function verificaVenta()
        {
           return true;                                                                                 
        }        

       <?php 
            }
       ?>
    });        

    function reset()
    {
         $.colorbox({
            href:"/Dashboard/Imprimir-Venta/"+respuesta,
            iframe: true,
            width: "50%",
            height: "50%"
        });      
        location.href = "/Dashboard/Ventas";        
    }
</script>
