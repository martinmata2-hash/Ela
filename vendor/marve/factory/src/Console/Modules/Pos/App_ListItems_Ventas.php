<?php

namespace App\ListItems;

use App\Models\Catalogos\Ajustes;
use App\Models\Catalogos\Productos;
use App\Models\Pos\Descuentos;
use Marve\Ela\Core\CurrentUser;
use Marve\Ela\Core\Generic;
use Marve\Ela\Html\Form\Input;
use Marve\Ela\Html\Form\Select;
use Marve\Ela\Html\Table\Tr;

class Ventas
{
    public static function getItem($producto, $cantidad, $precio, $porciento = 0.00)
    {
        if($precio == 1)
	        $Precio1 = "ProPrecio";
	    else 
			$Precio1 = "ProPrecio$precio";
        $IMPUESTOS = new Generic(CurrentUser::getDb(), "impuestos");
        $PRODUCTO = new Productos(CurrentUser::getDb());
        $AJUSTES = new Ajustes(CurrentUser::getDb());
        $DESCUENTO = new Descuentos(CurrentUser::getDb());
        $preciodescuento = $producto->$Precio1;
        $descuento = 0.00;
        $PRECIOS = new Select();
			$PRECIOS->fields("","","Precios","otrosprecios")
			->options(array(
				"$producto->ProPrecio2"=>$producto->ProPrecio2,
				"$producto->ProPrecio"=>$producto->ProPrecio,
				"$producto->ProPrecio2"=>$producto->ProPrecio2,
				"$producto->ProPrecio3"=>$producto->ProPrecio3,
				"$producto->ProPrecio4"=>$producto->ProPrecio4,
				"$producto->ProPrecio5"=>$producto->ProPrecio5),
				$producto->ProPrecio2);
        if($porciento > 0)
        {
            $preciodescuento = $preciodescuento - (($porciento / 100) * $preciodescuento);
        }
        else
        {
            $descuento = $DESCUENTO->descuento($producto);	
            if($descuento !== 0)
			{
				if($descuento["Tipo"] == "Descuento")
				{					
					$preciodescuento = $producto->$Precio1 - round(($descuento["porcentaje"] * $producto->$Precio1 )/100,2);
				}
				else
				{
					
					$condicion = explode(':',$descuento["condicion"]);
					switch ($condicion[0]) 
					{
						case 'cantidad':
							$preciodescuento = $producto->$Precio1 / $condicion[1];
							$cantidad = $condicion[1]
	;						break;
						
						default:
							$preciodescuento = $producto->$Precio1;
							break;
					}
				}		
            }	
        }       

        $TR = new Tr();
        $TR->tr("",($cantidad < 0)?"readonly_red":"")
			->td("","",1,(new Input("readonly"))->fields("","","","noenter ProCodigo border-0 p-0 m-0")->value($producto->ProCodigo))
			->td("","",1,(new Input("readonly"))->fields("","","","noenter ProDescripcion border-0 p-0 m-0")->value($producto->ProDescripcion))			
			->td("","",1,(new Input("number"))->fields("","","","noenter cantidad lineonly border-0 p-0 m-0 text-end")->value($cantidad)->step("0.001"))
			->td($PRECIOS->render(),"",($cantidad < 0)?0:1)			
			->td("","",1,(new Input("readonly"))->fields("","","","noenter ProPrecio1 lineonly border-0 p-0 m-0")->value($preciodescuento)->step("0.01"))			
			->td("","",1,(new Input("readonly"))->fields("","","","noenter importe lineonly border-0 p-0 m-0 text-end"))			
			->td("<button class='cut btn btn-primary'><i class='bi bi-eraser'></i></button>")
			->td("","",0,(new Input("hiden"))->fields("","","","ProPrecio")->value($producto->ProPrecio))
			->td("","",0,(new Input("hiden"))->fields("","","","ProIVA")->value($IMPUESTOS->get($producto->ProIVA, "ImpID")->ImpTasa))
			->td("","",0,(new Input("hiden"))->fields("","","","ProID")->value($producto->ProID))
			->td("","",0,(new Input("hiden"))->fields("","","","ProIEPS")->value($IMPUESTOS->get($producto->ProIEPS, "ImpID")->ImpTasa))
			->td("","",0,(new Input("hiden"))->fields("","","","promosion")->value(($descuento !== 0)?$cantidad:0))			
			->td("","",0,(new Input("hiden"))->fields("","","","parcial")->value(0));		
				
			
	        $mensaje["status"] = POS_SUCCESS;
	        $mensaje["html"] = $TR->renderSimple();
			$mensaje["promosion"] = $descuento;
            return $mensaje;
    }

    public static function getDetail($detalle)
    {
        $TR = new Tr();
        $TR->tr()
                ->td("","",1,(new Input("readonly"))->fields("","","","noenter ProCodigo border-0 p-0 m-0")->value($detalle->DdeCodigo))
                ->td("","",1,(new Input("readonly"))->fields("","","","noenter ProDescripcion border-0 p-0 m-0")->value($detalle->DdeDescripcion))
                ->td("","",1,(new Input("readonly"))->fields("","","","noenter cantidad lineonly border-0 p-0 m-0 text-end")->value($detalle->DdeCantidad)->step("0.001"))
                ->td("","",1,(new Input("readonly"))->fields("","","","noenter ProPrecio1 lineonly border-0 p-0 m-0")->value($detalle->DdePrecio)->step("0.01"))
                ->td("","",1,(new Input("readonly"))->fields("","","","noenter importe lineonly border-0 p-0 m-0 text-end"))
                ->td("<button class='cut btn btn-primary'><i class='bi bi-eraser'></i></button>")
                ->td("","",0,(new Input("hiden"))->fields("","","","ProPrecio")->value($detalle->DdePrecio))
                ->td("","",0,(new Input("hiden"))->fields("","","","ProIVA")->value($detalle->DdeIva))
                ->td("","",0,(new Input("hiden"))->fields("","","","ProID")->value($detalle->DdeProducto))
                ->td("","",0,(new Input("hiden"))->fields("","","","ProIEPS")->value($detalle->DdeIeps));
        return $TR->renderSimple();
    }
}