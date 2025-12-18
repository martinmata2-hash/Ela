<?php

namespace App\Forms;

use Marve\Ela\Html\Form\Form;
use Marve\Ela\Html\Form\GrupoInput;
use Marve\Ela\Html\Form\Input;
use Marve\Ela\Html\Form\Seccion;
use Marve\Ela\Html\Form\Select;
use Marve\Ela\Html\Form\TextArea;

class Proveedores 
{
    public static function form($arguments = null) 
    { 
         $FORMA = new Form(3,false,true);
        $FORMA->fields("proveedorForma", "proveedorForma", "Datos del Proveedor");
            $DIV = new Seccion();
            $DIV->fields("inicio");
        $FORMA->add($DIV);
            $RAZON = new Input("text");
            $RAZON->fields("ProvRazon", "ProvRazon", "Razon Social")
            ->validation("nombre",true, "Proveedores",true)
            ->hidden("ProvID", "ProvID");            
        $FORMA->add($RAZON);
            $RFC = new Input("text");
            $RFC->fields("ProvRfc", "ProvRfc", "RFC")->validation("rfc",false)
             ->value("XAXX010101000");
        $FORMA->add($RFC);
            $REGIMEN = new Select();
            $REGIMEN->fields("ProvRegimen", "CliRegimen", "Regimen")
            ->options(array("id"=>"0","nombre"=>"Selecciona Regimen"));
        $FORMA->add($REGIMEN);
            $EMPRESA = new Input("text");
            $EMPRESA->fields("ProvEmpresa", "ProvEmpresa", "Empresa");
        $FORMA->add($EMPRESA);
            $CONTACTO = new Input("text");
            $CONTACTO->fields("ProvContacto", "ProvContacto", "Contacto");
        $FORMA->add($CONTACTO);	
            $COBRANZA = new Input("text");
            $COBRANZA->fields("ProvCobranza", "ProvCobranza", "Contacto|Cobranza");
        $FORMA->add($COBRANZA);
            $DIV = new Seccion();
            $DIV->fields("fin");
        $FORMA->add($DIV);

            $DIV = new Seccion();
            $DIV->fields("inicio");
        $FORMA->add($DIV);
            $CELULAR = new Input("tel");
            $CELULAR->fields("ProvTelefono", "ProvTelefono", "Telefono")
            ->validation("telefono",false);
        $FORMA->add($CELULAR);	
            $TELEFONO = new Input("email");
            $TELEFONO->fields("ProvEmail", "ProvEmail", "Email")
            ->value("email@example.com");
        $FORMA->add($TELEFONO);	
            $NOTA = new TextArea();
            $NOTA->fields("ProvNota", "ProvNota", "Notas");
        $FORMA->add($NOTA);	
            $DIV = new Seccion();
            $DIV->fields("fin");
        $FORMA->add($DIV);

            $DIV = new Seccion();
            $DIV->fields("inicio");
        $FORMA->add($DIV);
            $CP = new Input("text");
            $CP->fields("ProvCp", "CliCp", "Codigo Postal")
            ->hidden("ProvPais", "CliPais","MEX");            
        $FORMA->add($CP);	
            $ESTADO = new Select();
            $ESTADO->fields("ProvEstado", "CliEstado", "Estado")
            ->options(array("id"=>0,"nombre"=>"Selecciona Estado"));            
        $FORMA->add($ESTADO);
            $MUNICIPIO = new Select();
            $MUNICIPIO->fields("ProvMunicipio", "CliMunicipio", "Municipio")
            ->options(array("id"=>0,"nombre"=>"Selecciona Municipio"))
            ->hidden("ProvMunicipio2", "CliMunicipio2");
        $FORMA->add($MUNICIPIO);
            $COLONIA = new Select();
            $COLONIA->fields("ProvColonia", "CliColonia", "Colonia")
            ->options(array("id"=>0,"nombre"=>"Selecciona Colonia"))
            ->hidden("ProvColonia2", "CliColinia2");
        $FORMA->add($COLONIA);
            $CALLE = new Input("text");
            $CALLE->fields("ProvCalle", "ProvCalle", "Calle");
        $FORMA->add($CALLE);
            $NUMERO = new GrupoInput("text");
            $NUMERO->fields("ProvNumeroExt","ProvNumeroExt","Numero Ext")
            ->input("ProvNumeroInt","ProvNumeroInt","","","Interior");
        $FORMA->add($NUMERO);
            $DIV = new Seccion();
            $DIV->fields("fin");
        $FORMA->add($DIV);
        return $FORMA->render();      
    }
}