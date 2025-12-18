<?php

namespace App\Forms;

use App\ListItems\Compras as ListItemsCompras;
use App\Models\Catalogos\Productos;
use App\Models\Data\CoDetallesD;
use Marve\Ela\Core\CurrentUser;
use Marve\Ela\Html\Form\Form;
use Marve\Ela\Html\Form\GrupoInput;
use Marve\Ela\Html\Form\GrupoSelect;
use Marve\Ela\Html\Form\Input;
use Marve\Ela\Html\Form\Select;
use Marve\Ela\Html\Table\Table;
use Marve\Ela\Html\Table\Tr;
use stdClass;

class Compras
{
    public static function forma()    
    {
     
    }


    public static function encabezado(stdClass $compra, $escompra = true)
    {
        $html = "<div class='col-md-12'>";        
        $FORMA = new Form(3);
            $CLIENTE = new GrupoSelect();
            if($escompra)
            {
                $CLIENTE->fields("FacEmisor","FacEmisor","Proveedor")
                ->options()->fromDB(CurrentUser::getDb(),"proveedores", "ProvRazon", "ProvID",$compra->FacEmisor??1)
                ->button("/Dashboard/Listas-Proveedores","fa-search", "buscaProveedor");                
            }
            else
            {
                $CLIENTE->fields("FacEmisor","FacEmisor","Cliente/Usuario")
                ->options()->fromDB(CurrentUser::getDb(),"clientes", "CliNombre", "CliID",$compra->FacEmisor??1)
                ->button("/Dashboard/Listas-Clientes","fa-search", "buscarCliente");                
            }
        $FORMA->add($CLIENTE);          
            $FOLIO = new Input("text");
            $FOLIO->fields("FacFolio","FacFolio", "Folio")
            ->validation("codigo", true,($escompra)?"Compras":"Movimientos",true)
            ->value($compra->FacFolio??""   )
            ->hidden("FacID","FacID","");
        $FORMA->add($FOLIO);
          $CODIGO = new GrupoInput("text");
            $CODIGO->fields("","codigo","Producto")    
            ->button("/Dashboard/Listas-Productos/1","fa-search", "buscaProductos");    
        $FORMA->add($CODIGO);
        $html .= $FORMA->noSubmit(true)->render();
        $html.= "</div>";
        return $html;        
    }

    
    public static function tablaProductos($detalles = null)
    {
        $html = "<div class='col-md-12'>";
        $PRODUCTO = new Productos(CurrentUser::getDb());        
        $htmlTr = "";
        if(!$detalles == null)
        foreach ($detalles as $detalle)
        {
            $detalle = new CoDetallesD($detalle);
            $producto = $PRODUCTO->get($detalle->DdeProducto, "ProID");
            if($producto->ProCompra == "")
                $producto->ProCompra = 0.00;
            $color = "";                      
            if($detalle->DdeCantidad < 0 )
                $backgorund = "bg-secondary text-white";
            else $backgorund = "";
                //////

            $htmlTr .= ListItemsCompras::getDetail($detalle);                
        }       

        
        $TABLA = new Table();
        $TABLA->inicio("","lista_productos","","bordered table-hover")
        ->header()->htr()->th("15%","Codigo")->th("35%","Descripcion")
        ->th("15%","Cantidad")->th("15%","Precio")->th("15%","Importe")
        ->body("tbody")->addBody($htmlTr);
        $html.= $TABLA->render();
        $html .= "
            <div class='row'>
                <div class='col-md-4'> </div>
                <div class='col-md-4 col-sm-6'> 
                    <br>       
                    <textarea id='FacNota' style='width: 100%' rows='7'>Notas: </textarea>   
                </div>
                <div class='col-md-4 ml-auto'>";
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
   
}