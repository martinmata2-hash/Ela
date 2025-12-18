<?php
namespace App\Models\Data;
use Marve\Ela\MySql\Interfaces\DataInterface;
use stdClass;

class ProductosD extends stdClass implements DataInterface
{
    /**
* @var int
*
*/public $ProID;
/**
* @var string
*
*/
public $ProCodigo;
/**
* @var string
*
*/
public $ProSustancia;
/**
* @var string
*
*/
public $ProDescripcion;
/**
* @var int
*
*/public $ProAntibiotico;
/**
* @var int
*
*/public $ProCategoria;
/**
* @var int
*
*/public $ProProveedor;
/**
* @var int
*
*/public $ProPaquete;
/**
* @var int
*
*/public $ProUltimoProveedor;
/**
* @var string
*
*/
public $ProMinimo;
/**
* @var string
*
*/
public $ProMaximo;
/**
* @var string
*
*/
public $ProCompra;
/**
* @var string
*
*/
public $ProPrecio;
/**
* @var string
*
*/
public $ProPrecio2;
/**
* @var string
*
*/
public $ProPrecio3;
/**
* @var string
*
*/
public $ProPrecio4;
/**
* @var string
*
*/
public $ProPrecio5;
/**
* @var string
*
*/
public $ProPrecio6;
/**
* @var string
*
*/
public $ProPorcentaje6;
/**
* @var string
*
*/
public $ProPorcentaje;
/**
* @var string
*
*/
public $ProPorcentaje2;
/**
* @var string
*
*/
public $ProPorcentaje3;
/**
* @var string
*
*/
public $ProPorcentaje4;
/**
* @var string
*
*/
public $ProPorcentaje5;
/**
* @var int
*
*/public $ProIEPS;
/**
* @var int
*
*/public $ProIVA;
/**
* @var string
*
*/
public $ProPresentacion;
/**
* @var string
*
*/
public $ProCaducidad;
/**
* @var int
*
*/public $ProSubCat;
/**
* @var int
*
*/public $ProMarca;
/**
* @var string
*
*/
public $ProPaqCantidad;
/**
* @var int
*
*/public $updated;
/**
* @var string
*
*/
public $ProAuxiliar;
/**
* @var string
*
*/
public $ProProSer;
/**
* @var string
*
*/
public $ProUnidad;
/**
* @var string
*
*/
public $ProLaboratorio;
/**
* @var string
*
*/
public $ProCodigoAlterno;
/**
* @var string
*
*/
public $ProEliminado;
/**
* @var string
*
*/
public $ProFolio;
/**
* @var string
*
*/
public $ProComision;
/**
* @var int
*
*/public $ProPadre;
/**
* @var string
*
*/
public $ProISH;
/**
* @var string
*
*/
public $ProUbicacion;
 
    public function __construct($datos = null)
    {
        try
        {
            if ($datos == null)
            {
                $this->ProID = 0;
$this->ProCodigo = "";
$this->ProSustancia = "";
$this->ProDescripcion = "";
$this->ProAntibiotico = 0;
$this->ProCategoria = 0;
$this->ProProveedor = 0;
$this->ProPaquete = 0;
$this->ProUltimoProveedor = 0;
$this->ProMinimo = "";
$this->ProMaximo = "";
$this->ProCompra = "";
$this->ProPrecio = "";
$this->ProPrecio2 = "";
$this->ProPrecio3 = "";
$this->ProPrecio4 = "";
$this->ProPrecio5 = "";
$this->ProPrecio6 = "";
$this->ProPorcentaje6 = "";
$this->ProPorcentaje = "";
$this->ProPorcentaje2 = "";
$this->ProPorcentaje3 = "";
$this->ProPorcentaje4 = "";
$this->ProPorcentaje5 = "";
$this->ProIEPS = 0;
$this->ProIVA = 0;
$this->ProPresentacion = "";
$this->ProCaducidad = "";
$this->ProSubCat = 0;
$this->ProMarca = 0;
$this->ProPaqCantidad = "";
$this->updated = 0;
$this->ProAuxiliar = "";
$this->ProProSer = "";
$this->ProUnidad = "";
$this->ProLaboratorio = "";
$this->ProCodigoAlterno = "";
$this->ProEliminado = "";
$this->ProFolio = "";
$this->ProComision = "";
$this->ProPadre = 0;
$this->ProISH = "";
$this->ProUbicacion = "";

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
        return "CREATE TABLE `productos` (
  `ProID` int(11) NOT NULL AUTO_INCREMENT,
  `ProCodigo` varchar(40) NOT NULL,
  `ProSustancia` tinytext NOT NULL,
  `ProDescripcion` tinytext NOT NULL,
  `ProAntibiotico` int(3) NOT NULL,
  `ProCategoria` int(11) NOT NULL,
  `ProProveedor` int(11) NOT NULL,
  `ProPaquete` int(1) NOT NULL,
  `ProUltimoProveedor` int(11) NOT NULL,
  `ProMinimo` decimal(10,2) NOT NULL,
  `ProMaximo` decimal(10,2) NOT NULL,
  `ProCompra` decimal(10,2) NOT NULL,
  `ProPrecio` decimal(10,2) NOT NULL,
  `ProPrecio2` decimal(10,2) NOT NULL,
  `ProPrecio3` decimal(10,2) NOT NULL,
  `ProPrecio4` decimal(10,2) NOT NULL,
  `ProPrecio5` decimal(10,2) NOT NULL,
  `ProPrecio6` decimal(10,2) NOT NULL,
  `ProPorcentaje6` decimal(6,2) NOT NULL,
  `ProPorcentaje` decimal(10,2) NOT NULL,
  `ProPorcentaje2` decimal(10,2) NOT NULL,
  `ProPorcentaje3` decimal(10,2) NOT NULL,
  `ProPorcentaje4` decimal(10,2) NOT NULL,
  `ProPorcentaje5` decimal(10,2) NOT NULL,
  `ProIEPS` int(11) NOT NULL,
  `ProIVA` int(11) NOT NULL,
  `ProPresentacion` varchar(50) NOT NULL,
  `ProCaducidad` date NOT NULL,
  `ProSubCat` int(11) NOT NULL,
  `ProMarca` int(11) NOT NULL,
  `ProPaqCantidad` decimal(10,2) NOT NULL,
  `updated` int(3) NOT NULL,
  `ProAuxiliar` tinytext NOT NULL,
  `ProProSer` varchar(8) NOT NULL,
  `ProUnidad` varchar(10) NOT NULL,
  `ProLaboratorio` varchar(40) NOT NULL,
  `ProCodigoAlterno` varchar(40) NOT NULL,
  `ProEliminado` tinyint(1) NOT NULL,
  `ProFolio` tinytext NOT NULL,
  `ProComision` decimal(10,2) NOT NULL,
  `ProPadre` int(11) NOT NULL,
  `ProISH` decimal(10,2) NOT NULL,
  `ProUbicacion` varchar(10) NOT NULL,
  PRIMARY KEY (`ProID`),
  KEY `proveedor` (`ProProveedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci";
    }
}
