<?php

namespace App\ListItems;

use App\Models\Catalogos\Productos;
use Marve\Ela\Core\CurrentUser;
use Marve\Ela\Core\Generic;
use Marve\Ela\Html\Form\Input;
use Marve\Ela\Html\Table\Tr;

class Compras
{
    public static function getItem($codigo, $cantidad)
    {
        $IMPUESTOS = new Generic(CurrentUser::getDb(), "impuestos");
        $PRODUCTO = new Productos(CurrentUser::getDb());
        $producto = $PRODUCTO->get($codigo, "ProCodigo");

        $TR = new Tr();
        $TR->tr()
                ->td("","",1,(new Input("readonly"))->fields("","","","noenter ProCodigo border-0 p-0 m-0")->value($producto->ProCodigo))
                ->td("","",1,(new Input("readonly"))->fields("","","","noenter ProDescripcion border-0 p-0 m-0")->value($producto->ProDescripcion))                
                ->td("","",1,(new Input("text"))->fields("","","","noenter cantidad lineonly border-0 p-0 m-0 ")->value($cantidad)->step("0.001"))                
                ->td("","",1,(new Input("text"))->fields("","","","noenter ProPrecio1 border-0 p-0 m-0")->value($producto->ProCompra)->step("0.01"))                
                ->td("","",1,(new Input("readonly"))->fields("","","","noenter importe border-0 p-0 m-0 text-end"))
                ->td("<button class='cut btn btn-primary'><i class='bi bi-eraser'></i></button>")
                ->td("","",0,(new Input("hiden"))->fields("","","","ProPrecio")->value($producto->ProCompra))
                ->td("","",0,(new Input("hiden"))->fields("","","","ProIVA")->value($IMPUESTOS->get($producto->ProIVA, "ImpID")->ImpTasa))
                ->td("","",0,(new Input("hiden"))->fields("","","","ProID")->value($producto->ProID))
                ->td("","",0,(new Input("hiden"))->fields("","","","ProIEPS")->value($IMPUESTOS->get($producto->ProIEPS, "ImpID")->ImpTasa));
        return $TR->renderSimple();
    }

    public static function getDetail($detalle)
    {
        $TR = new Tr();
        $TR->tr()
                ->td("","",1,(new Input("readonly"))->fields("","","","noenter ProCodigo border-0 p-0 m-0")->value($detalle->DdeCodigo))
                ->td("","",1,(new Input("readonly"))->fields("","","","noenter ProDescripcion border-0 p-0 m-0")->value($detalle->DdeDescripcion))
                ->td("","",1,(new Input("readonly"))->fields("","","","noenter cantidad lineonly border-0 p-0 m-0 ")->value($detalle->DdeCantidad)->step("0.001"))
                ->td("","",1,(new Input("readonly"))->fields("","","","noenter ProPrecio1 border-0 p-0 m-0")->value($detalle->DdePrecio)->step("0.01"))
                ->td("","",1,(new Input("readonly"))->fields("","","","noenter importe border-0 p-0 m-0 text-end"))
                ->td("<button class='cut btn btn-primary'><i class='bi bi-eraser'></i></button>")
                ->td("","",0,(new Input("hiden"))->fields("","","","ProPrecio")->value($detalle->DdePrecio))
                ->td("","",0,(new Input("hiden"))->fields("","","","ProIVA")->value($detalle->DdeIva))
                ->td("","",0,(new Input("hiden"))->fields("","","","ProID")->value($detalle->DdeProducto))
                ->td("","",0,(new Input("hiden"))->fields("","","","ProIEPS")->value($detalle->DdeIeps));
        return $TR->renderSimple();
    }
}