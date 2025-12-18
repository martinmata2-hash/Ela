<?php

namespace App\Forms;

use App\Models\Catalogos\Ajustes;
use Marve\Ela\Core\CurrentUser;
use Marve\Ela\Html\Form\Form;
use Marve\Ela\Html\Form\GrupoInput;
use Marve\Ela\Html\Form\GrupoSelect;
use Marve\Ela\Html\Form\Input;
use Marve\Ela\Html\Form\Seccion;
use Marve\Ela\Html\Form\Select;
use Marve\Ela\Html\Form\TextArea;

class Clientes
{
    public static function form($arguments = [])
    {
         
    $AJUSTES = new Ajustes(CurrentUser::getDb());  
        $FORMA = new Form(3,false,true);
        $FORMA->fields("clienteForma", "clienteForma", "Datos del Cliente");
            $DIV = new Seccion();
            $DIV->fields("inicio");
        $FORMA->add($DIV);
            $NOMBRE = new Input("text");
            $NOMBRE->fields("CliNombre", "CliNombre", "Razon Social")
            ->validation("nombre",true, "Clientes",true)
            ->hidden("CliID", "CliID")
            ->hidden("CliRazon", "CliRazon");
        $FORMA->add($NOMBRE);
            $RFC = new Input("text");
            $RFC->fields("CliRfc", "CliRfc", "RFC")->validation("rfc",false)
            ->value("XAXX010101000");
        $FORMA->add($RFC);
            $REGIMEN = new Select();
            $REGIMEN->fields("CliRegimen", "CliRegimen", "Regimen")
            ->options(array("id"=>"0","nombre"=>"Selecciona Regimen"));
        $FORMA->add($REGIMEN);
            $EMPRESA = new Input("text");
            $EMPRESA->fields("CliEmpresa", "CliEmpresa", "Empresa");
        $FORMA->add($EMPRESA);
            $PRECIO = new Select();
            $PRECIO->fields("CliPrecio", "CliPrecio", "Precio")
            ->options(["1"=>"Precio 1","2"=>"Precio 2","3"=>"Precio 3","4"=>"Precio 4", "5"=>"Precio 5"],1);
        $FORMA->add($PRECIO);	
        if($AJUSTES->get("CliDescuento","AjuNombre")->AjuValor > 0)
        {
                $DESCUENTO = new Input("number");
                $DESCUENTO->fields("CliPorciento", "CliPorciento", "% Descuento a Cliente")->step("0.01");
            $FORMA->add($DESCUENTO);	
        }
            $DIV = new Seccion();
            $DIV->fields("fin");
        $FORMA->add($DIV);

            $DIV = new Seccion();
            $DIV->fields("inicio");
        $FORMA->add($DIV);
        if($AJUSTES->get("CliCredito","AjuNombre")->AjuValor > 0)
        {
                $CREDITO = new Input("number");
                $CREDITO->fields("CliCredito", "CliCredito", "Credito Maximo")->value("0.00");
            $FORMA->add($CREDITO);
        }
            $MONEDERO = new Input("number");
            $MONEDERO->fields("CliPuntos", "CliPuntos", "Puntos Acumulados")->value("0.00");
        $FORMA->add($MONEDERO);
            $CELULAR = new Input("text");
            $CELULAR->fields("CliTelefono", "CliTelefono", "Telefono")->validation("telefono",false,"",true);
        $FORMA->add($CELULAR);	
            $EMAIL = new Input("text");
            $EMAIL->fields("CliEmail", "CliEmail", "Email")->validation("email",false)
            ->value("email@example.com");
        $FORMA->add($EMAIL);	
            $NOTA = new TextArea();
            $NOTA->fields("CliNota", "CliNota", "Notas");
        $FORMA->add($NOTA);	
            $DIV = new Seccion();
            $DIV->fields("fin");
        $FORMA->add($DIV);
            $DIV = new Seccion();
            $DIV->fields("inicio");
        $FORMA->add($DIV);  
        $rutas = $AJUSTES->get("CliRutas","AjuNombre");
        if($rutas !== 0 && $rutas->AjuValor > 0)
        {
                $INPUT = new GrupoSelect();
                $INPUT->fields("CliRuta", "CliRuta", "Ruta")
                ->fromDB(CurrentUser::getDb(), "rutas","RutNombre", "RutID",0)
                ->button("/Dashboard/Agregar-Ruta","fa-plus","agrgarRuta")
                ->button("#","fa-repeat","refrescarRuta","refrescarRutas(0); return false;");
            $FORMA->add($INPUT);
        }            
            $CP = new Input("text");
            $CP->fields("CliCp", "CliCp", "Codigo Postal")
            ->hidden("CliPais","CliPais","MEX");
        $FORMA->add($CP);	
            $ESTADO = new Select();
            $ESTADO->fields("CliEstado", "CliEstado", "Estado")->options(array("id"=>0,"nombre"=>"Selecciona Estado"));
        $FORMA->add($ESTADO);
            $MUNICIPIO = new Select();
            $MUNICIPIO->fields("CliMunicipio", "CliMunicipio", "Municipio")->options(array("id"=>0,"nombre"=>"Selecciona Municipio"))
            ->hidden("CliMunicipio2", "CliMunicipio2");
        $FORMA->add($MUNICIPIO);
            $COLONIA = new Select();
            $COLONIA->fields("CliColonia", "CliColonia", "Colonia")->options(array("id"=>0,"nombre"=>"Selecciona Colonia"))
            ->hidden("CliColonia2", "CliColinia2");
        $FORMA->add($COLONIA);
            $CALLE = new Input("text");
            $CALLE->fields("CliCalle", "CliCalle", "Calle");
        $FORMA->add($CALLE);
            $EXTERIOR = new GrupoInput("text");
            $EXTERIOR->fields("CliNumeroExt","CliNumeroExt","Numero Ext")
            ->input("CliNumeroInt","CliNumeroInt","","","Interior");
        $FORMA->add($EXTERIOR);
            $DIV = new Seccion();
            $DIV->fields("fin");
        $FORMA->add($DIV);
    return $FORMA->render();
}
}