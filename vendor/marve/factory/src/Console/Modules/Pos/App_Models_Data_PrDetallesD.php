<?php
namespace App\Models\Data;
use Marve\Ela\MySql\Interfaces\DataInterface;
use stdClass;

class PrDetallesD extends stdClass implements DataInterface
{
    /**
* @var int
*
*/public $DdeID;
/**
* @var int
*
*/public $DdeDocumento;
/**
* @var string
*
*/
public $DdeUnidad;
/**
* @var int
*
*/public $DdeProducto;
/**
* @var string
*
*/
public $DdeIva;
/**
* @var string
*
*/
public $DdeIeps;
/**
* @var string
*
*/
public $DdeCantidad;
/**
* @var string
*
*/
public $DdeDescripcion;
/**
* @var string
*
*/
public $DdePrecio;
/**
* @var string
*
*/
public $DdeImporte;
/**
* @var string
*
*/
public $DdeAduanaFecha;
/**
* @var int
*
*/public $DdeAduanaNumero;
/**
* @var string
*
*/
public $DdeProProSer;
/**
* @var string
*
*/
public $DdePredial;
/**
* @var string
*
*/
public $DdeISR;
/**
* @var string
*
*/
public $DdeRet;
/**
* @var string
*
*/
public $DdeDescuento;
/**
* @var string
*
*/
public $DdeReceta;
/**
* @var int
*
*/public $DdeParcial;
/**
* @var int
*
*/public $DdeMedico;
/**
* @var int
*
*/public $DdeFila;
/**
* @var string
*
*/
public $updated;
/**
* @var string
*
*/
public $DdeComision;
/**
* @var string
*
*/
public $DdeCodigo;
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
                $this->DdeID = 0;
$this->DdeDocumento = 0;
$this->DdeUnidad = "";
$this->DdeProducto = 0;
$this->DdeIva = "";
$this->DdeIeps = "";
$this->DdeCantidad = "";
$this->DdeDescripcion = "";
$this->DdePrecio = "";
$this->DdeImporte = "";
$this->DdeAduanaFecha = "";
$this->DdeAduanaNumero = 0;
$this->DdeProProSer = "";
$this->DdePredial = "";
$this->DdeISR = "";
$this->DdeRet = "";
$this->DdeDescuento = "";
$this->DdeReceta = "";
$this->DdeParcial = 0;
$this->DdeMedico = 0;
$this->DdeFila = 0;
$this->updated = "";
$this->DdeComision = "";
$this->DdeCodigo = "";
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
        return "CREATE TABLE `presupuestodetalles` (
  `DdeID` int(11) NOT NULL AUTO_INCREMENT,
  `DdeDocumento` int(11) NOT NULL,
  `DdeUnidad` varchar(20) NOT NULL,
  `DdeProducto` int(11) NOT NULL,
  `DdeIva` decimal(10,3) NOT NULL,
  `DdeIeps` decimal(5,3) NOT NULL,
  `DdeCantidad` decimal(10,3) NOT NULL,
  `DdeDescripcion` tinytext NOT NULL,
  `DdePrecio` decimal(10,2) NOT NULL,
  `DdeImporte` decimal(10,2) NOT NULL,
  `DdeAduanaFecha` date NOT NULL,
  `DdeAduanaNumero` int(11) NOT NULL,
  `DdeProProSer` varchar(10) NOT NULL,
  `DdePredial` varchar(12) NOT NULL,
  `DdeISR` decimal(10,6) NOT NULL,
  `DdeRet` decimal(10,6) NOT NULL,
  `DdeDescuento` decimal(12,2) NOT NULL,
  `DdeReceta` tinytext NOT NULL,
  `DdeParcial` int(11) NOT NULL,
  `DdeMedico` int(4) NOT NULL,
  `DdeFila` int(4) NOT NULL,
  `updated` tinyint(1) NOT NULL,
  `DdeComision` decimal(10,2) NOT NULL COMMENT 'comision de la venta',
  `DdeCodigo` varchar(30) NOT NULL,
  `TiendaID` int(11) NOT NULL,
  PRIMARY KEY (`DdeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci";
    }
}
