<?php

/**
 *
 * @version v2022_1
 *         
 * @author Martin Mata
 *        
 */

use App\Core\Access;
use App\Core\User;
use Marve\Ela\Core\CurrentUser;

global $inicio, $params;
if (! isset($params["UsuID"]) || $params["UsuID"] == 0) die("No se selecciono usuario");

$PERMISOS = new Access();
$USUARIO = new User();
?>

<h3>Agrega Permisos</h3>
<div class="border ui-corner-all">
	<input id='CSRF' type='hidden' value='<?php echo CurrentUser::getCsrf();?>' />

	<h3><?php echo $USUARIO->get($params["UsuID"],"UsuID")->UsuNombre; ?></h3>
	<br />
	<hr />
			
<?php echo $PERMISOS->render();  ?>
</div>
<br/>
	<div class='col-lg-12 col-xl-12'>
        <!-- Submit Button-->
        <div class='button-group text-center'>
            <button class='btn btn-primary' id='submitButtonPermisos' type="button">Archivar</button>
            <button class='btn btn-danger' id='resetButtonPermisos' type="button">Reset</button>
        </div>
    </div>

<script>

var add_button = false;
$(document).ready(function()
{
    obtenerpermisos(<?php echo $params["UsuID"];?>);
    function obtenerpermisos(usuario) //$("#permiso").change(function()
    {			            	 								
		var data = 
		{
			accion:"Permiso/get",
			data:{usuario:usuario},
			token:$("#CSRF").val()
		};
		
		return AjaxPeticiones.request("/Dashboard/AJax/Controller.php",data,actualizaTree);		
	}

	$("#submitButtonPermisos").click(function()
	    {
		    if($("#permisosusuarios").val() == "0")
		    {
				$("#permisosusuarios").notify("Selecciona usuario", "info")
				return false;
		    }
		    var permisos = "";
		    $("input:checkbox").each(function()
		    {
    			if($(this).is(':checked'))
    				if($(this).val() != "0")
    					permisos += $(this).val()+',';   
		    });
		    permisos = permisos.slice(0,-1);

						var data = 
				{
					accion:'Permiso/store',
					data:{PusUsuario:<?php echo $params["UsuID"]; ?>, PusPermisos:permisos},					
					token:$('#CSRF').val()
				};			
		    return AjaxPeticiones.request("/Dashboard/AJax/Controller.php",data,function(){obtenerpermisos(<?php echo $params["UsuID"];?>);},$("#submitButtonPermisos"));					
	    });		
     
        function reseteaTree(response)
        {
            $('input:checkbox').prop('checked','');		
        }
        function actualizaTree(response)
        {                
        	 $('input:checkbox').prop('checked','');			
        	var datos = response.PusPermisos.split(',');				
        	$.each(datos, function(i, value)
        	{
        		try
        		{			
            		
            		//seleccionar el checkbox que pertenece al permiso				
        			$("#id_"+ value).prop('checked', true);			
        		}
        		catch (e)
        		{
        			;
        		}
        	});	
        					
        }

        function cerrar(respuesta)
        {
        	self.close();
    	    parent.$.colorbox.close();    	   
    		parent.refrescar(respuesta);		
        }
        
        
        
});

</script>
