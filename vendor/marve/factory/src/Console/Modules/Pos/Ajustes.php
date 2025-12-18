<?php


/**
 *
 * @version v2022_1
 *         
 * @author Martin Mata
 *        
 */

use App\Forms\AjustesVentas;
use App\Models\Catalogos\Ajustes;
use Marve\Ela\Core\CurrentUser;

global $params;

$AJUSTES = new Ajustes(CurrentUser::getDb());
echo AjustesVentas::forma();

?>

<script>
$(document).ready(function()
{	     
    obtenerAJustes();
    $(".imprimir").change(function()
	{		
        if($(this).hasClass("form-check-input"))
        {
		    var value = ($(this).is(":checked"))?1:0;
            var tipo = 0;
        }
        else 
        {
            var value = $(this).val();
            var tipo = 1;
        }
        var nombre = $(this).attr("id");
        var descripcion = $("label[for='" + $(this).attr('id') + "']").html();
        var data = 
		{
			accion:'Ajuste/store',		
			data:{AjuNombre:nombre,AjuValor:value,AjuTipo:tipo, AjuDescripcion:descripcion},
			token:$("#CSRF").val()
		};		
        return AjaxPeticiones.request("/Dashboard/Ajax/Controller.php",data,function(){$.notify("ok","success");});											
	});

    function obtenerAJustes()
    {
        var data = 
		{
			accion:'Ajuste/getAll',		
			data:{Ajustes:1},
			token:$("#CSRF").val()
		};
        return AjaxPeticiones.request("/Dashboard/Ajax/Controller.php",data,mostrar);							
    }
    
    function mostrar(respuesta)
    {             
            $.each(respuesta, function (e,ajuste)
            {
                try
                {	   	                  		                      
                    if(ajuste.AjuTipo == 1)       							
                        $('#'+ajuste.AjuNombre).val(ajuste.AjuValor);
                    else
                    {
                        if(ajuste.AjuValor == 1)
                            $('#'+ajuste.AjuNombre).prop("checked",true);
                        else
                            $('#'+ajuste.AjuNombre).prop("checked",false);
                    }                               	 	                        
                }
                catch (e)
                {
                }
            });        
    }
});
</script>