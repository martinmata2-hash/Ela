<?php 
namespace App\Imprimir;


use App\Imprimir\Printer as ImprimirPrinter;
use App\Models\Catalogos\Ajustes;
use App\Models\Catalogos\Clientes;
use App\Models\Pos\Ventas;
use Exception;
use Marve\Ela\Core\CurrentUser;
use Mike42\Escpos\Printer;
use stdClass;

class Pago extends ImprimirPrinter
{
    public function __construct()
    {        
        parent::__construct((new Ajustes(CurrentUser::getDb()))->get("FacImpresora","AjuNombre")->AjuValor);   
    }

    public function imprimir(stdClass $pago, $original = true)
    {                
        $CLIENTE = new Clientes(CurrentUser::getDb());
        try
        {
            $this->printer->setJustification(Printer::JUSTIFY_CENTER);
            $this->printer->text("Pago a cuenta\n");
            $this->printer->feed();
           if(!$original)
             {
                $this->printer->setJustification(Printer::JUSTIFY_CENTER);           
                $this->printer->text("\n****** COPIA ******\n\n");    
                $this->printer->setJustification(Printer::JUSTIFY_LEFT);
             }
            $this->printer->text(new Ticket("Cajero: ".CurrentUser::getName()));            
            $this->printer->feed(1);
            if(isset($pago->cliente))
                $this->printer->text(new Ticket("Cliente: ".$CLIENTE->get($pago->cliente, "CliID")->CliNombre));
            elseif(isset($pago->PagVenta)) 
            {
                $venta = (new Ventas(CurrentUser::getDb()))->get($pago->PagVenta,"FacID");
                $this->printer->text(new Ticket("Cliente: ".$CLIENTE->get($venta->FacReceptor,"CliID")->CliNombre));
                $this->printer->text(new Ticket("Venta: ".$venta->FacID));
            }           
            $this->printer->setJustification(Printer::JUSTIFY_LEFT);
            $this->printer->text(new Ticket("","Cantidad ",$pago->PagCantidad));
            $this->printer->text("Pago a credito a la venta con folio $pago->PagVenta \n");
            $this->printer->feed(1);
            $this->printer->text("Firma  ________________");
            
            $this->printer->feed(6);
            //$this->printer->cut();
            $this->printer->close();
            return "Pago: archivado exitosamente";
        }
        catch(Exception $e)
        {
            return  "No se pudo imprimir ".$e->getMessage();
        }
    } 
    
}

