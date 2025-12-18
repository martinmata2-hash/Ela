<?php 

namespace App\Imprimir;


use App\Core\User;
use App\Imprimir\Printer as ImprimirPrinter;
use App\Models\Catalogos\Ajustes;
use App\Models\Catalogos\Clientes;
use Exception;
use Marve\Ela\Core\CurrentUser;
use Marve\Ela\Core\DateCalendar;
use Marve\Ela\Core\Encode;
use Mike42\Escpos\Printer;

class Venta extends ImprimirPrinter
{
     public function __construct()
    {
        parent::__construct((new Ajustes(CurrentUser::getDb()))->get("FacImpresora","AjuNombre")->AjuValor);   
    }

    public function imprimir($documento, $original = true)
    {
        $TICKET = new Ticket();
        $USUARIO = new User(CurrentUser::getDb());
        $CLIENTE = new Clientes(CurrentUser::getDb());
        try
        {
            $this->printer->setJustification(Printer::JUSTIFY_CENTER);           
            $this->printer->text($TICKET->encabezado());
            $this->printer->feed();
            $this->printer->text( DateCalendar::toWords($documento->FacFecha));
            $this->printer->feed(2);
            $this->printer->setJustification(Printer::JUSTIFY_LEFT);
            $this->printer->text("Folio :   $documento->FacID".PHP_EOL);
            $this->printer->text("Cajero:   ".$USUARIO->get($documento->FacUsuario,"UsuID")->UsuNombre.PHP_EOL);
            $this->printer->text("Cliente:  ".$CLIENTE->get($documento->FacReceptor,"CliID")->CliNombre.PHP_EOL);
            $this->printer->feed();
            $preciopublico = "";
            foreach($documento->Detalles as $value)
            {
                $this->printer->text(new Ticket($value->DdeCantidad, Encode::utf8($value->DdeDescripcion), $value->DdeImporte));
                if($value->DdeCantidad < 0)
                    $devolucion = "Devolucion: Firma ______________\n";
            }
            $this->printer->feed(3);            
            $this->printer->text("Forma de pago :". $TICKET->formapago($documento->FacFormaPago).PHP_EOL);
             if(!$original)
             {
                $this->printer->setJustification(Printer::JUSTIFY_CENTER);           
                $this->printer->text("\n****** COPIA ******\n\n");    
                $this->printer->setJustification(Printer::JUSTIFY_LEFT);
             }
            $this->printer->text(new Ticket("","Total",$documento->FacTotal));
            $this->printer->text(new Ticket("","Pago",$documento->FacParidad));
            $this->printer->text(new Ticket("","Cambio",$documento->FacParidad-$documento->FacTotal));
            $this->printer->feed(2);
            if(isset($devolucion) && !$original)
                $this->printer->text($devolucion);    
            $this->printer->text($TICKET->pie());
            $this->printer->feed(2);
            $this->printer->cut();            
            $this->printer->close();
            echo  "Venta: impresa exitosamente";
        }
        catch(Exception $e)
        {
            echo  "No se pudo imprimir ".$e->getMessage();
        }
    }

}