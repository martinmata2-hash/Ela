<?php

namespace App\Forms;

use Marve\Ela\Html\Form\Form;
use Marve\Ela\Html\Form\Input;

class Categorias 
{
    public static function form($arguments = null) 
    { 
        $FORMA = new Form(2,false);
        $FORMA->fields("categoriaForma","categoriaForma", "<center>Categoria</center>");
            $NOMBRE = new Input("text");
            $NOMBRE->fields("CatNombre", "CatNombre", "Nombre")
            ->validation("nombre",true, "Categorias",true)
            ->hidden("CatID", "CatID");
        $FORMA->add($NOMBRE);
        return $FORMA->render();        
    }

    public static function SubCatForm($arguments = null) 
    { 
         $FORMA = new Form(2,false);
        $FORMA->fields("subcatForma","subcatForma", "<center>Sub Categoria</center>");
            $NOMBRE = new Input("text");
            $NOMBRE->fields("SubNombre", "SubNombre", "Nombre")
            ->validation("nombre",true, "SubCat",true)
            ->hidden("SubID", "SubID");            
        $FORMA->add($NOMBRE);
        return $FORMA->render();        
    }

    public static function MarcasForm($arguments = null) 
    { 
        $FORMA = new Form(2,false);
        $FORMA->fields("marcasForma","marcasForma", "<center>Marca</center>");
            $NOMBRE = new Input("text");
            $NOMBRE->fields("MarNombre", "MarNombre", "Nombre")
            ->validation("nombre",true, "Marcas",true)
            ->hidden("MarID", "MarID");
        $FORMA->add($NOMBRE);
        return $FORMA->render();        
    }

}