<?php 
namespace App\Imprimir;

use App\Enum\Movimiento;
use App\Imprimir\Printer as ImprimirPrinter;
use App\Models\Catalogos\Ajustes;
use App\Models\Reportes\Flujos;
use CurlHandle;
use Exception;
use Marve\Ela\Core\CurrentUser;
use Mike42\Escpos\Printer;

class Corte extends ImprimirPrinter
{
    public function __construct()
    {        
        parent::__construct((new Ajustes(CurrentUser::getDb()))->get("FacImpresora","AjuNombre")->AjuValor);   
    }

    public function imprimir()
    {
        $FLUJO = new Flujos(CurrentUser::getDb());
        $totalVentas = $FLUJO->totalMovimiento(CurrentUser::getId(),Movimiento::Venta);
        $totalDevoluciones = $FLUJO->totalMovimiento(CurrentUser::getId(), Movimiento::Devolucion);
        $totalSalidas = $FLUJO->totalMovimiento(CurrentUser::getId(), Movimiento::Salida);
        $totalEntradas = $FLUJO->totalMovimiento(CurrentUser::getId(), Movimiento::Entrada);
        $totalPagos = $FLUJO->totalMovimiento(CurrentUser::getId(), Movimiento::Pago);
        $total = $FLUJO->total(CurrentUser::getId()); 
        try
        {
            $this->printer->setJustification(Printer::JUSTIFY_CENTER);
            $this->printer->text("Corte de caja\n");
            $this->printer->feed();
            $this->printer->text(new Ticket("Cajero ".CurrentUser::getName()));
            $this->printer->feed(2);
            $this->printer->setJustification(Printer::JUSTIFY_LEFT);
            $this->printer->text(new Ticket("","Ventas ",$totalVentas));
            $this->printer->text(new Ticket("","Devoluciones ", $totalDevoluciones));
            $this->printer->text(new Ticket("","Salidas ",$totalSalidas));
            $this->printer->text(new Ticket("","Entradas ",$totalEntradas));
            $this->printer->text(new Ticket("","Pagos Recibidos ",$totalPagos));
            $this->printer->text(new Ticket("","Total ",$total));
            $this->printer->feed(6);
            //$this->printer->cut();
            $this->printer->close();
            return "Corte: archivado exitosamente";
        }
        catch(Exception $e)
        {
            return  "No se pudo imprimir ".$e->getMessage();
        }
    } 
    
}

