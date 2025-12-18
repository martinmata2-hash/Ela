<?php


namespace App\Forms;

use Marve\Ela\Core\CurrentUser;
use Marve\Ela\Html\Form\Form;
use Marve\Ela\Html\Form\Input;
use Marve\Ela\Html\Form\Seccion;
use Marve\Ela\Html\Form\Select;
use stdClass;

class Users
{
    public static function login()
    {
     $FORMA = new Form(1,true,false);
        $FORMA->fields("usuarioForma","usuarioForma","<center>Ingresar A Plataforma</center>");
            $DIV = new Seccion();
            $DIV->fields("inicio")->value(4);
        $FORMA->add($DIV);
            $USUARIO = new Input("text");
            $USUARIO->fields("usuario","usuario","Usuario");	
        $FORMA->add($USUARIO);
            $PASS = new Input("password");
            $PASS->fields("clave","clave","Clave");	
        $FORMA->add($PASS);
            $DIV = new Seccion();
            $DIV->fields("fin");
        $FORMA->add($DIV);
        $FORMA->sumitButtonLabel("Login");	
        return $FORMA->render();       
    }

     public static function renewPassword(stdClass $usuario)
    {
        $FORMA = new Form(4, false, false);
	$FORMA->fields("claveForma","claveForma","Cambiar Clave");
		$NOMBRE = new Select();
        $NOMBRE->fields("","Nombres","Usuarios")
        ->fromDB(CurrentUser::getDb(),"usuarios", "UsuNombre","UsuID",$usuario->UsuID,"UsuActivo = 1");
    $FORMA->add($NOMBRE);
		$NOMBRE2 = new Input("readonly");
		$NOMBRE2->fields("","UsuNombre2","Nombre")->value($usuario->UsuNombre)
		->hidden("UsuID","UsuID2", $usuario->UsuID);
	$FORMA->add($NOMBRE2);
		$CLAVE = new Input("text");
		$CLAVE->fields("UsuClave","UsuClave1","Clave");
	$FORMA->add($CLAVE);
		$CLAVE2 = new Input("text");
		$CLAVE2->fields("","UsuClave2","Repetir Clave");
	$FORMA->add($CLAVE2);		
	return $FORMA->render();      
    }	

    public static function usuario()
    {
        $FORMA = new Form("4",false, false);
	    $FORMA->fields("usuarioForma","usuarioForma","Datos de Usuario");
        /*    $EMPRESA = new Input(((Session::getRol() == 1)?"text":"readonly"));
            $EMPRESA->fields("UsuEmpresa","UsuEmpresa","Empresa")
            ->value(Session::getBussiness());
        $FORMA->add($EMPRESA);
        */
            $NOMBRE = new Input("text");
            $NOMBRE->fields("UsuNombre","UsuNombre","Nombre Completo")
            ->validation("nombre",true,"Usuarios",true)
            ->hidden("","CSRF", CurrentUser::getCsrf())
            ->hidden("UsuID", "UsuID");
        $FORMA->add($NOMBRE);
            $USU = new Input("text");
            $USU->fields("UsuUsuario","UsuUsuario","Usuario")
            ->validation("usuario",true,"Usuario",true)
            ->hidden("UsuBd","UsuBd",CurrentUser::getDb());
        $FORMA->add($USU);
            $CLAVE = new Input("text");
            $CLAVE->fields("UsuClave","UsuClave","Clave")
            ->validation("length",false,"Usuario",true,3);
        $FORMA->add($CLAVE);
            $ROL = new Select();
            $ROL->fields("UsuRol","UsuRol","Función")
            ->fromDB(CurrentUser::getDb(),"rol", "RolNombre","RolID","0","RolID > ".Session::getRol());
        $FORMA->add($ROL);
        return $FORMA->render();
    }
}