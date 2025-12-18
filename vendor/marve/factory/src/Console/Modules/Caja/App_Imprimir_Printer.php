<?php 
namespace App\Imprimir;

use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer as EscposPrinter;

class Printer
{
    /**
     * Summary of connector
     * @var WindowsPrintConnector
     */
    protected $connector;
    /**
     * Summary of printer
     * @var EscposPrinter
     */
    protected $printer;
    public function __construct(string $impresora)
    {
        $this->connector = new WindowsPrintConnector($impresora);
        $this->printer = new EscposPrinter($this->connector);
    }
}