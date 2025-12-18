<?php
namespace App\Models\Data;
use Marve\Ela\MySql\Interfaces\DataInterface;
use stdClass;

class MovimientosD extends stdClass implements DataInterface
{
    /**
* @var int
*
*/public $FacID;
/**
* @var string
*
*/
public $FacFolio;
/**
* @var int
*
*/public $FacEmisor;
/**
* @var int
*
*/public $FacReceptor;
/**
* @var string
*
*/
public $FacFecha;
/**
* @var string
*
*/
public $FacFormaPago;
/**
* @var string
*
*/
public $FacMetodoPago;
/**
* @var string
*
*/
public $FacSubtotal;
/**
* @var string
*
*/
public $FacIva;
/**
* @var string
*
*/
public $FacDescuento;
/**
* @var string
*
*/
public $FacTotal;
/**
* @var string
*
*/
public $FacEstado;
/**
* @var string
*
*/
public $FacCancelada;
/**
* @var string
*
*/
public $FacNota;
/**
* @var string
*
*/
public $FacCuenta;
/**
* @var string
*
*/
public $FacIEPS;
/**
* @var string
*
*/
public $FacRecibio;
/**
* @var string
*
*/
public $FacUpdated;
/**
* @var string
*
*/
public $updated;
/**
* @var string
*
*/
public $FacTipo;
/**
* @var int
*
*/public $FacUsuario;
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
                $this->FacID = 0;
$this->FacFolio = "";
$this->FacEmisor = 0;
$this->FacReceptor = 0;
$this->FacFecha = "";
$this->FacFormaPago = "";
$this->FacMetodoPago = "";
$this->FacSubtotal = "";
$this->FacIva = "";
$this->FacDescuento = "";
$this->FacTotal = "";
$this->FacEstado = "";
$this->FacCancelada = "";
$this->FacNota = "";
$this->FacCuenta = "";
$this->FacIEPS = "";
$this->FacRecibio = "";
$this->FacUpdated = "";
$this->updated = "";
$this->FacTipo = "";
$this->FacUsuario = 0;
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
        return "CREATE TABLE `salidas` (
  `FacID` int(11) NOT NULL AUTO_INCREMENT,
  `FacFolio` tinytext NOT NULL,
  `FacEmisor` int(11) NOT NULL,
  `FacReceptor` int(11) NOT NULL,
  `FacFecha` datetime NOT NULL,
  `FacFormaPago` tinytext NOT NULL,
  `FacMetodoPago` tinytext DEFAULT NULL,
  `FacSubtotal` decimal(10,2) NOT NULL,
  `FacIva` decimal(10,2) NOT NULL,
  `FacDescuento` decimal(10,2) DEFAULT NULL,
  `FacTotal` decimal(10,2) NOT NULL,
  `FacEstado` tinyint(1) NOT NULL,
  `FacCancelada` tinyint(1) NOT NULL,
  `FacNota` text NOT NULL,
  `FacCuenta` text NOT NULL,
  `FacIEPS` tinytext NOT NULL,
  `FacRecibio` decimal(10,2) NOT NULL,
  `FacUpdated` datetime NOT NULL DEFAULT current_timestamp(),
  `updated` tinyint(1) NOT NULL,
  `FacTipo` tinytext NOT NULL COMMENT '0: Salida; 1:Entrada',
  `FacUsuario` int(11) NOT NULL,
  `TiendaID` int(11) NOT NULL,
  PRIMARY KEY (`FacID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci";
    }
}
