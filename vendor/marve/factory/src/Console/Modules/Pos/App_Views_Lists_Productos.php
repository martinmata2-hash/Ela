<?php

use App\Grids\Productos as GridsProductos;
use App\Models\Catalogos\Productos;
use Marve\Ela\Core\CurrentUser;
use Marve\Ela\Grid\Datagrid;

global $params;


$PRODUCTO = new Productos(CurrentUser::getDb());

if($params["option"] == "Padres")
	$where = " Where ProPaquete > 0";
else
	$where = "";
////////////////Productos

$GRID = new Datagrid();
$GRID->inicio(CurrentUser::getDb());

    
$editar = false;
$ediusuario = false;

$categoria = $GRID->g->get_dropdown_values("select distinct CatID as k, CatNombre as v from categorias order by CatNombre");
$subcategoria = $GRID->g->get_dropdown_values("select distinct SubID as k, SubNombre as v from subcat order by SubNombre");
$proveedor = $GRID->g->get_dropdown_values("select distinct ProvID as k, ProvRazon as v from proveedores order by ProvRazon");


$GRID->campos(GridsProductos::grid(array("editar"=>$editar,"editusuario"=>$ediusuario,
"categorias"=>$categoria, "subcat"=>$subcategoria, "proveedores"=>$proveedor)));

if($params["option"] == "Descuento")
	$GRID->encabezado("Productos", "ProCodigo", array(
    	false,true,false,true,true, true), "desc", 500);
else
	$GRID->encabezado("Productos", "ProCodigo", array(
    	false,true,false,true,true), "desc", 500);
$GRID->sql("select distinct p.*, InvCantidad from 
    productos p inner join inventarios on InvProducto = ProID $where", "productos");
$clientes = $GRID->mostrar();

 echo $clientes; 
 
if($params["option"] == "Descuento")
{
	echo "<button class='btn btn-primary' id='archivar'>Seleccionar</button>";	
}
 ?>

 <script>

	<?php 
		if($params["option"] == "Descuento")
		{
			echo "
			$('#archivar').click(function()
			{
				parent.$('#producto').val(jQuery('#list1').jqGrid('getGridParam','selarrrow'));
				self.close();
    			parent.$.colorbox.close();
			});";
		}
		else
		{
			echo "
				var opts = 
					{	
						'onCellSelect': function (rowid,icol,cellcontent) 
						{		    	   
							//parent.$('#ubicacion').val(jQuery('#list1').jqGrid('getCell', rowid, 'InvUbicacion'));
							parent.$('#codigo').val(jQuery('#list1').jqGrid('getCell', rowid, 'ProCodigo')).focus();
							var e = jQuery.Event('keydown');
							e.which = 13;
							parent.$('#codigo').trigger(e);											
							self.close();
							parent.$.colorbox.close();				
						}
					}
					";
		}
		?>

</script>