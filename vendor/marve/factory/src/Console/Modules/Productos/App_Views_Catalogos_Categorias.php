<?php

use App\Grids\Categorias as GridsCategorias;
use App\Models\Catalogos\Categorias;
use Marve\Ela\Core\CurrentUser;
use Marve\Ela\Grid\Datagrid;

$CATEGORIA = new Categorias(CurrentUser::getDb());

////////////////Categorias

$GRID = new Datagrid();
$GRID->inicio(CurrentUser::getDb());

    $editar = CurrentUser::isSupervisor();

$GRID->campos(GridsCategorias::grid(array("editar"=>$editar)));

$GRID->encabezado("Categorias", "CatNombre", array(
    	false,true,false,true,true), "desc", 300);
$GRID->sql("select distinct * from categorias", "categorias");
$categorias = $GRID->mostrar();

 
$GRID = new Datagrid();
$GRID->inicio(CurrentUser::getDb());

$GRID->campos(GridsCategorias::subcat(array("editar"=>$editar)));

$GRID->encabezado("Sub Categorias", "SubNombre", array(
    	false,true,false,true,true), "desc", 300);
$GRID->sql("select distinct * from subcat", "subcat");
$subcat = $GRID->mostrar(2);


$GRID = new Datagrid();
$GRID->inicio(CurrentUser::getDb());

$GRID->campos(GridsCategorias::marcas(array("editar"=>$editar)));

$GRID->encabezado("Marcas", "MarNombre", array(
    	false,true,false,true,true), "desc", 300);
$GRID->sql("select distinct * from marcas", "marcas");
$marcas = $GRID->mostrar(3);



 echo $categorias;
 echo "<hr><br>";
 echo $subcat;
 echo "<hr><br>";
 echo $marcas;
 ?>
<script>

</script>