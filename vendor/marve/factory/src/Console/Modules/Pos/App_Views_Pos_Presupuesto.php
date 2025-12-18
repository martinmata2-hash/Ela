<?php

use App\Forms\Ventas as FormsVentas;
use App\Models\Catalogos\Ajustes;
use App\Models\Pos\Presupuestos;
use Marve\Ela\Core\CurrentUser;
use Marve\Ela\Core\Session;

@session_start();

global $params;

$VENTAS = new Presupuestos(CurrentUser::getDb());
$AJUSTES = new Ajustes(CurrentUser::getDb());

$venta = 0;

if(isset($params["FacID"]))
{
    $venta = $VENTAS->get($params["FacID"], "FacID");
    $venta->FacNota = str_replace(array('\r\n', '\n\r', '\r', '\n'),"\n",$venta->FacNota);    
}


?>

<div class="mt-0 d-none d-md-block">  
    <button class="btn btn-outline-success me-4" type="button">Cliente &emsp; shift &larr; </button>
    <button class="btn btn-outline-success me-4" type="button">Pagar &emsp; shift &darr; </button>    
    <button class="btn btn-outline-success me-4" type="button">Codigo &emsp; shift &rarr; </button>
    <button class="btn btn-outline-success me-4" type="button">Buscar &emsp; shift &uarr; </button>    
    <button class="btn btn-outline-success me-4" type="button">Archivar &emsp; shift Enter </button>
    <button onclick="window.location = '/Dashboard/Ventas'" class="btn btn-outline-primary me-6" type="button">Menu</button>  
</div>
<hr/>
<h3 style="color: red;">VENTA</h3>
<div class='row gx-5 justify-content-center'>
    <div class='col-lg-10 col-md-9'>
        <div class='row'>
            <?php
            echo FormsVentas::encabezado();
            echo FormsVentas::tablaProductos(($venta->Detalles)??"");
            unset($venta->Detalles);
            //$venta_json = json_encode($venta, JSON_FORCE_OBJECT);
            echo FormsVentas::pagos();
            ?>


            <div class='col-lg-6 col-xl-6'>
                <!-- Submit Button-->
                <div class='button-group text-center'>
                    <button type="button" class='btn btn-primary archivar' id='submitButtonVenta'>
                        Archivar</button>
                    <button type="button" class='btn btn-danger' id='resetButtonVenta'>
                        Limpiar</button>
                </div>
            </div>
        </div>
    </div>
    <div class='col-lg-2 col-md-3 border border-primary'>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="ventacredito">
            <label class="form-check-label" for="ventacredito">VENTA A CREDITO</label>
        </div>      
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
    $(document).ready(function() 
    {
        
        $(document).on('click keyup',function(event){ VentaObject.calcular();});
	       
        $("#resetButtonVenta").click(function(){reset();})

        $("#FacReceptor").change();
       
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
            /*       
            var tr = $(this).parent().parent();
            var cantidad = $(this).val()*1;           
            try
            {
                var tempcantidad = (tr.find(".promosion").text()) || 0;                
                if(cantidad < tempcantidad)                
                    tr.find(".ProPrecio1").text(tr.find(".otrosprecios option:eq(2)").val());                
                else
                    tr.find(".ProPrecio1").text(tr.find(".otrosprecios option:eq(0)").val());

            }
            catch(e)
            {

            } 
            */          
        });
      
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
                    accion:'Presupuesto/store',		
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
                emptyColumn = tr.html;		   				    			    		
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
	    	$.each(tr, function(i,value)
	    	{
	    		$("#"+i).notify(value,"info");		
	    	});		
            if(tr.promosion != 0)
            {
                if(tr.promosion.Tipo == 'Promosion')
                    $("#panelProducto").append("<h6>"+$(emptyColumn).find(".ProDescripcion").text()+" -|- "+tr.promosion.Nombre+"</h6>");
                else if(tr.promosion.Tipo == 'Descuento')
                    $("#panelProducto").append("<h6>"+$(emptyColumn).find(".ProDescripcion").text()+" -|- "+tr.promosion.Nombre+"  "+tr.promosion.porcentaje+" %</h6>");
            }                       	    	    	    
	    }

        function verificaVenta()
        {
            return true;            
        }

        $("#ventacredito").change(function()
        {
            if(Credito <= 0)
            {    
                $(this).notify("El Cliente no tiene credito disponible","error");
                $("#ventacredito").prop("checked",false);
            }    
            if($("#ventacredito").is(":checked"))
            {                
                $("#FacRecibio").prop("readOnly", true);
                $("#FacRecibio2").prop("readOnly", true);
                $("#FacRecibio3").prop("readOnly", true);
            }     
            else
            {
                $("#FacRecibio").prop("readOnly", false);
                $("#FacRecibio2").prop("readOnly", false);
                $("#FacRecibio3").prop("readOnly", false);
            }   

        });
       
    });            

    function reset()
    {
        location.reload();       
    }
</script>