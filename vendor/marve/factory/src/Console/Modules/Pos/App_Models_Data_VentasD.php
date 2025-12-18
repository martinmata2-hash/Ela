<?php
namespace App\Models\Data;
use Marve\Ela\MySql\Interfaces\DataInterface;
use stdClass;

class VentasD extends stdClass implements DataInterface
{
    /**
* @var int
*
*/public $FacID;
/**
* @var string
*
*/
public $FacTipoComprobante;
/**
* @var string
*
*/
public $FacDatos;
/**
* @var string
*
*/
public $FacSerie;
/**
* @var string
*
*/
public $FacFolio;
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
public $FacFormaPago2;
/**
* @var string
*
*/
public $FacFormaPago3;
/**
* @var string
*
*/
public $FacIdentificacion2;
/**
* @var string
*
*/
public $FacIdentificacion3;
/**
* @var string
*
*/
public $FacRecibio2;
/**
* @var string
*
*/
public $FacRecibio3;
/**
* @var string
*
*/
public $FacFolioPago;
/**
* @var string
*
*/
public $FacFolioPago2;
/**
* @var string
*
*/
public $FacFolioPago3;
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
public $FacMotivoDescuento;
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
public $FacSelloCFD;
/**
* @var string
*
*/
public $FacFechaTimbrado;
/**
* @var string
*
*/
public $FacUUID;
/**
* @var string
*
*/
public $FacNoCertificadoSat;
/**
* @var string
*
*/
public $FacVersion;
/**
* @var string
*
*/
public $FacSelloSAT;
/**
* @var string
*
*/
public $FacCadenaOriginal;
/**
* @var string
*
*/
public $FacXml;
/**
* @var string
*
*/
public $FacCbb;
/**
* @var string
*
*/
public $FacRet;
/**
* @var string
*
*/
public $FacIsr;
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
public $FacSucursal;
/**
* @var string
*
*/
public $FacMoneda;
/**
* @var string
*
*/
public $FacParidad;
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
public $FacIdentificacion;
/**
* @var int
*
*/public $FacUsuario;
/**
* @var string
*
*/
public $FacAcesor;
/**
* @var int
*
*/public $TiendaID;
/**
* @var int
*
*/public $FacMedico;
/**
* @var int
*
*/public $FacEmisor;
 
    public function __construct($datos = null)
    {
        try
        {
            if ($datos == null)
            {
                $this->FacID = 0;
$this->FacTipoComprobante = "";
$this->FacDatos = "";
$this->FacSerie = "";
$this->FacFolio = "";
$this->FacReceptor = 0;
$this->FacFecha = "";
$this->FacFormaPago = "";
$this->FacMetodoPago = "";
$this->FacFormaPago2 = "";
$this->FacFormaPago3 = "";
$this->FacIdentificacion2 = "";
$this->FacIdentificacion3 = "";
$this->FacRecibio2 = "";
$this->FacRecibio3 = "";
$this->FacFolioPago = "";
$this->FacFolioPago2 = "";
$this->FacFolioPago3 = "";
$this->FacSubtotal = "";
$this->FacIva = "";
$this->FacDescuento = "";
$this->FacMotivoDescuento = "";
$this->FacTotal = "";
$this->FacEstado = "";
$this->FacCancelada = "";
$this->FacSelloCFD = "";
$this->FacFechaTimbrado = "";
$this->FacUUID = "";
$this->FacNoCertificadoSat = "";
$this->FacVersion = "";
$this->FacSelloSAT = "";
$this->FacCadenaOriginal = "";
$this->FacXml = "";
$this->FacCbb = "";
$this->FacRet = "";
$this->FacIsr = "";
$this->FacNota = "";
$this->FacCuenta = "";
$this->FacSucursal = "";
$this->FacMoneda = "";
$this->FacParidad = "";
$this->FacIEPS = "";
$this->FacRecibio = "";
$this->FacUpdated = "";
$this->updated = "";
$this->FacIdentificacion = "";
$this->FacUsuario = 0;
$this->FacAcesor = "";
$this->TiendaID = 0;
$this->FacMedico = 0;
$this->FacEmisor = 0;

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
        return "CREATE TABLE `ventas` (
  `FacID` int(11) NOT NULL AUTO_INCREMENT,
  `FacTipoComprobante` tinytext NOT NULL,
  `FacDatos` tinyint(4) NOT NULL,
  `FacSerie` varchar(20) NOT NULL,
  `FacFolio` mediumint(9) unsigned NOT NULL,
  `FacReceptor` int(11) NOT NULL,
  `FacFecha` datetime NOT NULL,
  `FacFormaPago` tinytext NOT NULL,
  `FacMetodoPago` tinytext DEFAULT NULL,
  `FacFormaPago2` varchar(4) NOT NULL,
  `FacFormaPago3` varchar(4) NOT NULL,
  `FacIdentificacion2` varchar(30) NOT NULL,
  `FacIdentificacion3` varchar(30) NOT NULL,
  `FacRecibio2` decimal(10,2) NOT NULL,
  `FacRecibio3` decimal(10,2) NOT NULL,
  `FacFolioPago` varchar(20) NOT NULL,
  `FacFolioPago2` varchar(20) NOT NULL,
  `FacFolioPago3` varchar(20) NOT NULL,
  `FacSubtotal` decimal(10,2) NOT NULL,
  `FacIva` decimal(10,2) NOT NULL,
  `FacDescuento` decimal(10,2) DEFAULT NULL,
  `FacMotivoDescuento` tinytext DEFAULT NULL,
  `FacTotal` decimal(10,2) NOT NULL,
  `FacEstado` tinyint(1) NOT NULL,
  `FacCancelada` tinyint(1) NOT NULL,
  `FacSelloCFD` tinytext NOT NULL,
  `FacFechaTimbrado` tinytext NOT NULL,
  `FacUUID` tinytext NOT NULL,
  `FacNoCertificadoSat` varchar(25) NOT NULL,
  `FacVersion` varchar(5) NOT NULL,
  `FacSelloSAT` tinytext NOT NULL,
  `FacCadenaOriginal` text NOT NULL,
  `FacXml` text NOT NULL,
  `FacCbb` text NOT NULL,
  `FacRet` decimal(10,2) NOT NULL DEFAULT 0.00,
  `FacIsr` decimal(10,2) NOT NULL DEFAULT 0.00,
  `FacNota` text NOT NULL,
  `FacCuenta` text NOT NULL,
  `FacSucursal` varchar(200) NOT NULL,
  `FacMoneda` varchar(20) NOT NULL DEFAULT 'MXN',
  `FacParidad` decimal(10,2) NOT NULL DEFAULT 1.00,
  `FacIEPS` tinytext NOT NULL,
  `FacRecibio` decimal(10,2) NOT NULL,
  `FacUpdated` datetime NOT NULL,
  `updated` tinyint(1) NOT NULL,
  `FacIdentificacion` tinytext NOT NULL,
  `FacUsuario` int(11) NOT NULL,
  `FacAcesor` varchar(10) NOT NULL,
  `TiendaID` int(11) NOT NULL,
  `FacMedico` int(11) NOT NULL,
  `FacEmisor` int(11) NOT NULL,
  PRIMARY KEY (`FacID`),
  KEY `venta_fecha` (`FacFecha`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci";
    }
}
