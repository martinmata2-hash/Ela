<?php

namespace App\Forms;

use Marve\Ela\Html\Form\Form;
use Marve\Ela\Html\Form\Input;
use Marve\Ela\Html\Form\Select;
use Marve\Ela\Html\Form\TextArea;

class Cajas
{
    public static function form()
    {
         $FORM = new Form(3);
        $FORM->fields("movimientoForma", "movimientoForma","Movimiento de Efectivo");
            $TIPO = new Select();
            $TIPO->fields("CajTipo","CajTipo","Tipo de movimiento")
            ->options([0=>"Entrada de dinero",1=>"Salida de dinero"],0);
        $FORM->add($TIPO);            
            $CANTIDAD = new Input("number");
            $CANTIDAD->fields("CajCantidad","CajCantidad","Cantidad")->step("0.01");
        $FORM->add($CANTIDAD);
            $NOTA = new TextArea();
            $NOTA->fields("CajDescripcion","CajDescripcion","Descripcion o Notas")
            ->value("Notas:");
        $FORM->add($NOTA);
        return $FORM->sumitButtonLabel("Archivar Movimiento")->render();
    }
}