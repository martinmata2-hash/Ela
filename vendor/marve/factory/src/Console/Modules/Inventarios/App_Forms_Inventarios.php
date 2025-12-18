<?php 

namespace App\Forms;

use Marve\Ela\Core\CurrentUser;
use Marve\Ela\Html\Form\Form;
use Marve\Ela\Html\Form\GrupoInput;
use Marve\Ela\Html\Form\Seccion;
use Marve\Ela\Html\Form\Select;
use Marve\Ela\Html\Table\Table;

class Inventarios
{
    public static function form()
    {
        $FORM = new Form(1,false,true);
        $FORM->fields("inventarioForma","inventarioForma","<center>AJustes de Inventarios</center>");
             $DIV = new Seccion();
            $DIV->fields("inicio");
        $FORM->add($DIV);
            $CATEGORIAS = new Select();
            $CATEGORIAS->fields("Categorias", "Categorias","Categorias")
            ->fromDB(CurrentUser::getDb(),"categorias","CatNombre","CatID",0);
        $FORM->add($CATEGORIAS);
            $SUBCAT = new Select();
            $SUBCAT->fields("Subcat", "Subcat","Sub Categorias");
        $FORM->add($SUBCAT);
         $TABLA = new Table();
        $TABLA->inicio("listaProductos","listaProductos","Inventario","bordered table-hover table-stripped")
        ->header()->htr()->th("15%","Check")->th("30%","Codigo")->th("30%","Descripcion")
        ->th("20%","<a href='#' class='btn btn-primary' onclick='printList'>Imprimir</a>")
        ->body("tbody");
        $FORM->add($TABLA);
            $DIV = new Seccion();
            $DIV->fields("fin");
        $FORM->add($DIV);
            $DIV = new Seccion();
            $DIV->fields("inicio");
        $FORM->add($DIV);      

            $RAZON = new Select();
            $RAZON->fields("Razon","Razon","Razon de ajuste")
            ->options(["periodico"=>"Inventario","Dañado"=>"Dañado","Caduco"=>"Caduco","Robo"=>"Robo"],"periodico");
        $FORM->add($RAZON);
            $CODIGO = new GrupoInput("text");
            $CODIGO->fields("Codigo","codigo","Producto")
            ->button("/Dashboard/Listas-Productos/1","fa-search","buscarProducto");
        $FORM->add($CODIGO);

        $TABLA = new Table();
        $TABLA->inicio("Inventory","inventory","Inventario","bordered table-hover table-stripped")
        ->header()->htr()->th("30%","Codigo")->th("30%","Descripcion")->th("15%","Inventario")->th("20%","Ajuste")
        ->body("tbody");
        $FORM->add($TABLA);
         $DIV = new Seccion();
            $DIV->fields("fin");
        $FORM->add($DIV);
        return $FORM->sumitButtonLabel("Archivar")->render();
        
    }
}