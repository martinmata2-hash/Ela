<?php

namespace App\Forms;

use App\Core\User;
use App\ListItems\Ventas as ListItemsVentas;
use App\Models\Catalogos\Productos;
use App\Models\Data\VeDetallesD;
use Marve\Ela\Core\CurrentUser;
use Marve\Ela\Core\DotEnv;
use Marve\Ela\Html\Form\Form;
use Marve\Ela\Html\Form\GrupoInput;
use Marve\Ela\Html\Form\GrupoSelect;
use Marve\Ela\Html\Form\Input;
use Marve\Ela\Html\Form\Select;
use Marve\Ela\Html\Table\Table;
use Marve\Ela\Html\Table\Tr;

class Ventas
{
    public static function forma()    
    {
     
    }


    public static function encabezado($venta = null)
    {
        $html = "<div class='col-md-12'>";        
        $FORMA = new Form(3);
            $CLIENTE = new GrupoSelect();
            $CLIENTE->fields("FacReceptor","FacReceptor","Cliente")
                ->options()->fromDB(CurrentUser::getDb(),"clientes", "CliNombre", "CliID",$venta->FacReceptor??1)
                ->button("/Dashboard/Listas-Clientes","fa-search", "buscaClientes");                
        $FORMA->add($CLIENTE);
            $CODIGO = new GrupoInput("text");
            $CODIGO->fields("","codigo","Producto")    
            ->button("/Dashboard/Listas-Productos/1","fa-search", "buscaProductos");    
        $FORMA->add($CODIGO);
            $TOTAL = new Input("readonly");
            $TOTAL->fields("FacTotal","FacTotal", "Total","total")
            ->hidden("FacID","FacID",$venta->FacID??0)
            ->value($venta->FacTotal??0.00);
        $FORMA->add($TOTAL);
        $html .= $FORMA->noSubmit(true)->render();
        $html.= "</div>";
        return $html;        
    }

    
    public static function tablaProductos($detalles = null)
    {
        $html = "<div class='col-md-8'>";
        $PRODUCTO = new Productos(CurrentUser::getDb());
        
        $htmlTr = "";
        if(!$detalles == null)
        foreach ($detalles as $detalle)
        {
            $detalle = new VeDetallesD($detalle);
            $producto = $PRODUCTO->get($detalle->DdeProducto, "ProID");
            if($producto->ProCompra == "")
                $producto->ProCompra = 0.00;
            $color = "";
             
            if($detalle->DdeCantidad < 0 )
                $backgorund = "bg-secondary text-white";
            else $backgorund = "";
                //////
               $htmlTr .= ListItemsVentas::getDetail($detalle);                       

                //$html .= $TR->renderSimple();						
        }       

        
        $TABLA = new Table();
        $TABLA->inicio("","lista_productos","","bordered table-hover")
        ->header()->htr()->th("10%","Codigo")->th("25%","Descripcion")
        ->th("10%","Cantidad")->th("20%","Precios")->th("15%","Precio")->th("10%","Importe")
        ->body("tbody")->addBody($htmlTr);
        $html.= $TABLA->render();
        $html .= "
            <div class='row'>
                <div class='col-lg-4 col-sm-6'> 
                    <br>       
                    <textarea id='FacNota' style='width: 100%' rows='7'>Notas: </textarea>   
                </div>
                <div class='col-lg-8 col-sm-6 ml-auto'>";
            $TABLA = new Table();
            $TABLA->inicio("","","","bordered table-hover");
            $INPUT = new Input("readonly");
            $INPUT->fields("","subtotal","","lineonly twodigits");
            $INPUT2 = new Input("readonly");
            $INPUT2->fields("","iva","","lineonly twodigits");
            $INPUT3 = new Input("readonly");
            $INPUT3->fields("","ieps","","lineonly twodigits");
            $INPUT4 = new Input("number");
            $INPUT4->fields("","descuento","","lineonly twodigits")->value("0.00")->step("0.01");
            $INPUT5 = new Input("readonly");
            $INPUT5->fields("","total",""," total lineonly twodigits");
            $TABLA->inicio("","","","table-bordered table-hover")
            ->body()
            ->tr()->td("Subtotal")->td("","",1,$INPUT)
            ->tr()->td("IVA")->td("","",1,$INPUT2)
            ->tr()->td("IEPS")->td("","",1,$INPUT3)
            ->tr()->td("Descuento")->td("","",1,$INPUT4)
            ->tr()->td("Total")->td("","",1,$INPUT5);
        $html .= $TABLA->render();
        
        $html .="
                </div></div></div>";
            return $html;
    }

    public static function pagos($venta = null)
    {        
        $html = " 
        <div class='col-md-4 g-0'>";
        if(isset($venta) && isset($venta->FacUsuario))
        {               
            $html .="<h3>".(new User(CurrentUser::getDb()))->get($venta->FacUsuario,"UsuID")->UsuNombre."</h3>";
        }
        else        
            $html .= "<br>";             
        $html .="</hr class='clear'></br>";


        $PAGOS = new Form(2); 
        $PAGOS->fields("pagoForma","pagoForma","","gx-2");               
            $TOTAL = new Input("readonly");
            $TOTAL->fields("","","Total","total fs-3");
        $PAGOS->add($TOTAL);
            $CAMBIO = new Input("readonly");
            $CAMBIO->fields("","cambio","Cambio","fs-3")
            ->value($venta?$venta->FacTotal - $venta->FacRecibio:0.00);
        $PAGOS->add($CAMBIO);           
            $FORMA1 = new Select();
            $FORMA1->fields("","FacFormaPago","Pago")
            ->fromDB(DotEnv::getDB(), "c_formapago","ForDescripcion","ForCodigo","01");
        $PAGOS->add($FORMA1);
            $RECIBIO = new Input("number");
            $RECIBIO->fields("","FacRecibio","Cantidad", "recibio")->step("0.01")->value($venta->FacRecibio ?? 0);
        $PAGOS->add($RECIBIO);
            $FOLIO = new Input("number");
            $FOLIO->fields("","FacFolio","Folio");
        $PAGOS->add($FOLIO);
            $TELEFONO = new Input("text");
            $TELEFONO->fields("","FacIdentificacion","Id");
        $PAGOS->add($TELEFONO);
        $html .= $PAGOS->noSubmit(false)->render();

        $PAGOS = new Form(2);
        $PAGOS->fields("","formaPago2","<span id='pago2'>Forma de Pago 2</span>");            
            $FORMA2 = new Select();
            $FORMA2->fields("","FacFormaPago2","Pago")
            ->fromDB(DotEnv::getDB(),"c_formapago","ForDescripcion","ForCodigo","01");
        $PAGOS->add($FORMA2);
            $RECIBIO2 = new Input("number");
            $RECIBIO2->fields("","FacRecibio2","Cantidad", "recibio")->step("0.01")->value($venta->FacRecibio2 ?? 0);
        $PAGOS->add($RECIBIO2);
            $FOLIO2 = new Input("number");
            $FOLIO2->fields("","FacFolio2","Folio 2");
        $PAGOS->add($FOLIO2);
            $TELEFONO2 = new Input("text");
            $TELEFONO2->fields("","FacIdentificacion2","Id 2");
        $PAGOS->add($TELEFONO2);
        $html .= $PAGOS->noSubmit(false)->render();

        $PAGOS = new Form(2);
        $PAGOS->fields("","formaPago3","<span id='pago3'>Forma de Pago 3</span>");            
            $FORMA3 = new Select();
            $FORMA3->fields("","FacFormaPago3","Pago")
            ->fromDB(DotEnv::getDB(), "c_formapago","ForDescripcion","ForCodigo","01");
        $PAGOS->add($FORMA3);
            $RECIBIO3 = new Input("number");
            $RECIBIO3->fields("","FacRecibio3","Cantidad", "recibio")->step("0.01")->value($venta->FacRecibio3 ?? 0);
        $PAGOS->add($RECIBIO3);
            $FOLIO3 = new Input("number");
            $FOLIO3->fields("","FacFolio3","Folio 3");
        $PAGOS->add($FOLIO3);
            $TELEFONO3 = new Input("text");
            $TELEFONO3->fields("","FacIdentificacion3","Id 3");
        $PAGOS->add($TELEFONO3);
        $html .= $PAGOS->noSubmit(false)->render();
          
        $html .= "</div>";
    return $html;
    }

}