<?php 
namespace App\Imprimir;


use App\Imprimir\Printer as ImprimirPrinter;
use App\Models\Catalogos\Ajustes;
use Exception;
use Marve\Ela\Core\CurrentUser;
use Mike42\Escpos\Printer;
use stdClass;

class Movimiento extends ImprimirPrinter
{
    public function __construct()
    {        
        parent::__construct((new Ajustes(CurrentUser::getDb()))->get("FacImpresora","AjuNombre")->AjuValor);   
    }

    public function imprimir(stdClass $caja, $original = true)
    {                
        
        try
        {
            $this->printer->setJustification(Printer::JUSTIFY_CENTER);
            $this->printer->text("Movimiento de efectivo\n");
            $this->printer->feed();
           if(!$original)
             {
                $this->printer->setJustification(Printer::JUSTIFY_CENTER);           
                $this->printer->text("\n****** COPIA ******\n\n");    
                $this->printer->setJustification(Printer::JUSTIFY_LEFT);
             }
            $this->printer->text(new Ticket("Cajero: ".CurrentUser::getName()));
            $this->printer->feed(1);
            $this->printer->setJustification(Printer::JUSTIFY_LEFT);
            $this->printer->text(new Ticket("","Cantidad ",$caja->CajCantidad));
            $this->printer->text($caja->CajDescripcion."\n");
            $this->printer->feed(1);
            $this->printer->text("Firma  ________________");
            
            $this->printer->feed(6);
            //$this->printer->cut();
            $this->printer->close();
            return "Moviemiento: archivado exitosamente";
        }
        catch(Exception $e)
        {
            return  "No se pudo imprimir ".$e->getMessage();
        }
    } 
    
}

