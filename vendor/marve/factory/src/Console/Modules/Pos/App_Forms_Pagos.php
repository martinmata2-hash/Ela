<?php 

namespace App\Forms;

use Marve\Ela\Core\CurrentUser;
use Marve\Ela\Core\DotEnv;
use Marve\Ela\Html\Form\Form;
use Marve\Ela\Html\Form\Input;
use Marve\Ela\Html\Form\Select;
use Marve\Ela\Html\Form\TextArea;

class Pagos
{
    public static function form($argumens = [])
    {
        $FORM = new Form(3);
        $FORM->fields("pagosForma", "pagosForma","Pagos");
            $CLIENTE = new Select();
            $CLIENTE->fields("cliente","cliente","Cliente")
            ->fromDB(CurrentUser::getDb(),"clientes","CliNombre","CliID",0,0,"CliNombre");
        $FORM->add($CLIENTE);
            $FORMA = new Select();
            $FORMA->fields("PagFormaPago","formapago","Pago")
            ->fromDB(DotEnv::getDB(), "c_formapago","ForDescripcion","ForCodigo","01");
        $FORM->add($FORMA);
            $CANTIDAD = new Input("number");
            $CANTIDAD->fields("PagCantidad","cantidad","Cantidad")->step("0.01");
        $FORM->add($CANTIDAD);
            $NOTA = new TextArea();
            $NOTA->fields("PagNota","nota","Notas")
            ->value("Notas:");
        $FORM->add($NOTA);
        return $FORM->sumitButtonLabel("Archivar Pago")->render();
    }
}