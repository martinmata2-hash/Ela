<?php

namespace App\Enum;

enum Movimiento: int
{
    case Venta = 1;
    case Devolucion = 3;
    case Entrada = 6;
    case Salida = 5;
    case Pago = 7;

    public function toString()
    {
        return match ($this) 
        {
            self::Venta => "Venta en mostrador",
            self::Devolucion => "Devolucion de productos en mostrador",
            self::Salida => "Salida de efectivo",
            self::Entrada => "Entrada de efectivo",
            self::Pago => "Pago a credito en mostrador",
            default => "No identificado"
        };
    }
}
