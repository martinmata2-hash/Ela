<?php
namespace App\ListItems;

use Marve\Ela\Html\Form\Input;
use Marve\Ela\Html\Table\Tr;
use \App\Models\Catalogos\Inventarios as InvCatalogo;
class Inventarios
{
    public static function getItem($producto, $cantidad)
    {
        $existencias = (new InvCatalogo())->get($producto->ProID, "InvProducto")->InvCantidad;
        $request = array();

        $TR = new Tr();
        $TR->tr()
        ->td("","",1,(new Input("readonly"))->fields("","","noenter ProCodigo border-0 p-0 m-0")->value($producto->ProCodigo))
        ->td("","",1,(new Input("readonly"))->fields("","","","noenter ProDescripcion border-0 p-0 m-0")->value($producto->ProDescripcion))        
        ->td("","",1,(new Input("readonly"))->fields("","","","noenter importe border-0 p-0 m-0")->value($existencias))
        ->td("","",1,(new Input("text"))->fields("","","","noenter cantidad lineonly border-0 p-0 m-0 ")->value($cantidad)->step("0.01"))
        ->td("","",0,(new Input("hiden"))->fields("","","","ProID")->value($producto->ProID));
		
		$mensaje["status"] = POS_SUCCESS;
		$mensaje["html"] = $TR->renderSimple();	
		return $mensaje;

    }
}
	