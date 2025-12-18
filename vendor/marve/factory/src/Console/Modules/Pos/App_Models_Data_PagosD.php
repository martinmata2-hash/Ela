<?php
namespace App\Models\Data;
use Marve\Ela\MySql\Interfaces\DataInterface;
use stdClass;

class PagosD extends stdClass implements DataInterface
{
    /**
* @var int
*
*/public $PagID;
/**
* @var int
*
*/public $PagVenta;
/**
* @var string
*
*/
public $PagCantidad;
/**
* @var string
*
*/
public $PagParcial;
/**
* @var string
*
*/
public $PagFecha;
/**
* @var string
*
*/
public $updated;
/**
* @var string
*
*/
public $PagNota;
/**
* @var int
*
*/public $PagUsuario;
/**
* @var string
*
*/
public $PagFormaPago;
/**
* @var int
*
*/public $TiendaID;
 
    public function __construct($datos = null)
    {
        try
        {
            if ($datos == null)
            {
                $this->PagID = 0;
$this->PagVenta = 0;
$this->PagCantidad = "";
$this->PagParcial = "";
$this->PagFecha = "";
$this->updated = "";
$this->PagNota = "";
$this->PagUsuario = 0;
$this->PagFormaPago = "";
$this->TiendaID = 0;

            }
            else
            {
                foreach ($datos as $k => $v)
                {
                    $this->$k = $v;
                }
            }
        }
        catch (\Exception $e)
        {}
    }
    public function sql()
    {
        return "CREATE TABLE `pagos` (
  `PagID` int(11) NOT NULL AUTO_INCREMENT,
  `PagVenta` int(11) NOT NULL,
  `PagCantidad` decimal(10,2) NOT NULL,
  `PagParcial` decimal(10,2) NOT NULL,
  `PagFecha` datetime NOT NULL DEFAULT current_timestamp(),
  `updated` tinyint(1) NOT NULL,
  `PagNota` tinytext NOT NULL,
  `PagUsuario` int(11) NOT NULL,
  `PagFormaPago` tinytext NOT NULL,
  `TiendaID` int(11) NOT NULL,
  PRIMARY KEY (`PagID`),
  KEY `fecha_index` (`PagFecha`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci";
    }
}
