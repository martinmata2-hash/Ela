<?php

namespace App\Forms;

use App\Models\Catalogos\Ajustes;
use Marve\Ela\Core\CurrentUser;
use Marve\Ela\Core\DotEnv;
use Marve\Ela\Html\Form\Form;
use Marve\Ela\Html\Form\GrupoInput;
use Marve\Ela\Html\Form\GrupoSelect;
use Marve\Ela\Html\Form\Input;
use Marve\Ela\Html\Form\Seccion;
use Marve\Ela\Html\Form\Select;

class Productos 
{
    public static function form($arguments = [])
    {        
        
        $AJUSTES = new Ajustes(CurrentUser::getDb());
        $FORM = new Form(3,true,true);
        $FORM->fields("productoForma","productoForma","Datos del Producto");
            $DIV = new Seccion();
            $DIV->fields("inicio");
        $FORM->add($DIV);
            $CODIGO = new Input("text");
            $CODIGO->fields("ProCodigo", "ProCodigo", "Codigo")
                ->validation("codigo",true,"Productos",true)
                ->hidden("ProID","ProID");
        $FORM->add($CODIGO);
            $DESCRIPCION = new Input("text");
            $DESCRIPCION->fields("ProDescripcion","ProDescripcion","Descripcion")
                ->validation("nombre",true,"Productos",true);
        $FORM->add($DESCRIPCION);
            $APLICACION = new Input("text");
            $APLICACION->fields("ProSustancia","ProSustancia","Aplicacion");
        $FORM->add($APLICACION);            
            $COMPRA = new Input("number");
            $COMPRA->fields("ProCompra","ProCompra","Precio Compra")->step("0.01")->value("0.00");
        $FORM->add($COMPRA);
            $PRECIO = new GrupoInput("number");
            $PRECIO->fields("ProPrecio","ProPrecio","Precio 1","precio")->step("0.01")->value("0.00")->data("ProPorcentaje")
            ->input("ProPorcentaje","ProPorcentaje",$AJUSTES->get("ProPorcentaje", "AjuNombre")->AjuValor,"porcentaje","%","ProPrecio");
        $FORM->add($PRECIO);
            $PRECIO2 = new GrupoInput("number");
            $PRECIO2->fields("ProPrecio2","ProPrecio2","Precio 2","precio")->step("0.01")->value("0.00")->data("ProPorcentaje2")
            ->input("ProPorcentaje2","ProPorcentaje2",$AJUSTES->get("ProPorcentaje2", "AjuNombre")->AjuValor,"porcentaje","%","ProPrecio2");
        $FORM->add($PRECIO2);
            $PRECIO3 = new GrupoInput("number");
            $PRECIO3->fields("ProPrecio3","ProPrecio3","Precio 3","precio")->step("0.01")->value("0.00")->data("ProPorcentaje3")
            ->input("ProPorcentaje3","ProPorcentaje3",$AJUSTES->get("ProPorcentaje3", "AjuNombre")->AjuValor,"porcentaje","%","ProPrecio3");
        $FORM->add($PRECIO3);
            $PRECIO4 = new GrupoInput("number");
            $PRECIO4->fields("ProPrecio4","ProPrecio4","Precio 4","precio")->step("0.01")->value("0.00")->data("ProPorcentaje4")
            ->input("ProPorcentaje4","ProPorcentaje4",$AJUSTES->get("ProPorcentaje4", "AjuNombre")->AjuValor,"porcentaje","%","ProPrecio4");
        $FORM->add($PRECIO4);
            $PRECIO5 = new GrupoInput("number");
            $PRECIO5->fields("ProPrecio5","ProPrecio5","Precio 5","precio")->step("0.01")->value("0.00")->data("ProPorcentaje5")
            ->input("ProPorcentaje5","ProPorcentaje5",$AJUSTES->get("ProPorcentaje5", "AjuNombre")->AjuValor,"porcentaje","%","ProPrecio5");
        $FORM->add($PRECIO5);
            $PRECIO6 = new GrupoInput("number");
            $PRECIO6->fields("ProPrecio6","ProPrecio6","Precio 6","precio")->step("0.01")->value("0.00")->data("ProPorcentaje6")
            ->input("ProPorcentaje6","ProPorcentaje6",$AJUSTES->get("ProPorcentaje6", "AjuNombre")->AjuValor,"porcentaje","%","ProPrecio6");
        $FORM->add($PRECIO6);
            $DIV = new Seccion();
            $DIV->fields("fin");
        $FORM->add($DIV);


            $DIV = new Seccion();
            $DIV->fields("inicio");
        $FORM->add($DIV);
            $PROSER = new Input(	"text");
            $PROSER->fields("ProProSer","ProProSer","Proser CFDI")->value("01010101")
            ->validation("length",false,"",true,8);
        $FORM->add($PROSER);
            $UNIDAD = new Input(	"text");
            $UNIDAD->fields("ProUnidad","ProUnidad","Unidad")->value("H87")
            ->validation("length",false,"",true,2);
        $FORM->add($UNIDAD);
            $IVA = new Select();
            $IVA->fields("ProIVA", "ProIVA","IVA")
            ->fromDB(DotEnv::getDB(),"impuestos", "ImpNombre", "ImpID",$AJUSTES->get("ProIVA", "AjuNombre")->AjuValor,"ImpTipo = 'iva'"); 
        $FORM->add($IVA);
            $IEPS = new Select();
            $IEPS->fields("ProIEPS", "ProIEPS","IEPS")
            ->fromDB(DotEnv::getDB(),"impuestos", "ImpNombre", "ImpID",$AJUSTES->get("ProIEPS", "AjuNombre")->AjuValor,"ImpTipo = 'ieps'"); 
        $FORM->add($IEPS);
            $MAX = new Input(	"text");
            $MAX->fields("ProMaximo","ProMaximo","Maximo")->value("5")
            ->validation("length",false,"",true,1);
        $FORM->add($MAX);
            $MIN = new Input(	"text");
            $MIN->fields("ProMinimo","ProMinimo","Minimo")->value("1")
            ->validation("length",false,"",true,1);
        $FORM->add($MIN);            
            $PAQUETE = new Input(	"checkbox");
            $PAQUETE->fields("ProPaquete","ProPaquete","<b> &nbsp;&nbsp; <u>Es Paquete?</b></u>");
        $FORM->add($PAQUETE);
            $CANTIDAD = new Input("number");
            $CANTIDAD->fields("ProPaqCantidad","ProPaqCantidad","Cantidad por Pqt")->value("0");
        $FORM->add($CANTIDAD);
            $PADRE = new GrupoSelect();
            $PADRE->fields("ProPadre", "ProPadre","Padre")->options()
            ->fromDB(CurrentUser::getDb(),"productos", "ProDescripcion", "ProID",0,"ProPaquete > 0","ProDescripcion")
            ->button("/Dashboard/Lista-Productos/Padre","fa-search","buscarPadre"); 
        $FORM->add($PADRE);
            $DIV = new Seccion();
            $DIV->fields("fin");
        $FORM->add($DIV);


            $DIV = new Seccion();
            $DIV->fields("inicio");
        $FORM->add($DIV);
            $CODIGO = new Input("text");
            $CODIGO->fields("ProCodigoAlterno", "ProCodigoAlterno", "Codigo Alt")
                ->validation("codigo",true,"Productos",false); //$tipo,$unico,$modelo,$requerido, $length
        $FORM->add($CODIGO);
            $UBICACION = new Input("text");
            $UBICACION->fields("ProUbicacion", "ProUbicacion", "Ubicación A-01")
                ->validation("lenght",false,"",true,2)->value("A-01"); 
        $FORM->add($UBICACION);
            $PROVEEDOR = new GrupoSelect();
            $PROVEEDOR->fields("ProProveedor", "ProProveedor","Proveedor")
            ->fromDB(CurrentUser::getDb(),"proveedores", "ProvRazon", "ProvID",1,"0" )
            ->button("/Dashboard/Proveedor","fa-plus","agregarProveedor")
            ->button("","fa-refresh","refrescarProveedores","refrescarProveedores(1);  return false;");
        $FORM->add($PROVEEDOR);        
            $CATEGORIA = new GrupoSelect();
            $CATEGORIA->fields("ProCategoria", "ProCategoria","Categoria")
            ->fromDB(CurrentUser::getDb(),"categorias", "CatNombre", "CatID",1,"0" )
            ->button("/Dashboard/Categoria","fa-plus","agregarCategoria")
            ->button("","fa-refresh","refrescarCategoria","refrescarCategorias(1);  return false;");
        $FORM->add($CATEGORIA);
            $SUB = new GrupoSelect();
            $SUB->fields("ProSubCat", "ProSubCat","Sub Categoria")
            ->fromDB(CurrentUser::getDb(),"subcat", "SubNombre", "SubID",1,"0" )
            ->button("/Dashboard/SubCat","fa-plus","agregarSubCat")
            ->button("","fa-refresh","refrescarSubCat","refrescarSubCat(1);  return false;");
        $FORM->add($SUB);
            $MARCA = new GrupoSelect();
            $MARCA->fields("ProMarca", "ProMarca","Marca")
            ->fromDB(CurrentUser::getDb(),"marcas", "MarNombre", "MarID",1,"0" )
            ->button("/Dashboard/Marca","fa-plus","agregarMarca")
            ->button("","fa-refresh","refrescarMarcas","refrescarMarcas(1); return false;");
        $FORM->add($MARCA);
            $AUXILIAR = new GrupoInput("textarea");
            $AUXILIAR->fields("ProAuxiliar", "ProAuxiliar", "Relacionados", "input-group")
            ->button("/Dashboard/Listas-Eqivalencias","fa-search", "buscarEquivalencias");
        //$FORM->add($AUXILIAR);
        if($AJUSTES->get("ProAntibiotico","AjuNombre")->AjuValor != "0")
        {
            $ANTIBIOTICO = new Input(	"checkbox");
            $ANTIBIOTICO->fields("ProAntibiotico","ProAntibiotico","<b>  &nbsp;&nbsp; <u>Es Antibiotico?</u></b>");
        $FORM->add($ANTIBIOTICO);
        }
            $DIV = new Seccion();
            $DIV->fields("fin");
        $FORM->add($DIV);
        return $FORM->render();
    }           
}