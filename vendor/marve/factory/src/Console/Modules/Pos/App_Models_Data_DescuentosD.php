<?php
namespace App\Models\Data;
use Marve\Ela\MySql\Interfaces\DataInterface;
use stdClass;

class DescuentosD extends stdClass implements DataInterface
{
    /**
* @var int
*
*/public $DesID;
/**
* @var string
*
*/
public $DesTipo;
/**
* @var string
*
*/
public $DesObjetivo;
/**
* @var string
*
*/
public $DesProductos;
/**
* @var string
*
*/
public $DesCategorias;
/**
* @var string
*
*/
public $DesSubCat;
/**
* @var string
*
*/
public $DesNombre;
/**
* @var string
*
*/
public $DesPrecio;
/**
* @var string
*
*/
public $DesCondicion;
/**
* @var string
*
*/
public $DesInicia;
/**
* @var string
*
*/
public $DesTermina;
/**
* @var string
*
*/
public $DesPorcentaje;
/**
* @var string
*
*/
public $DesDescripcion;
/**
* @var int
*
*/public $DesUsuario;
/**
* @var string
*
*/
public $updated;
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
                $this->DesID = 0;
$this->DesTipo = "";
$this->DesObjetivo = "";
$this->DesProductos = "";
$this->DesCategorias = "";
$this->DesSubCat = "";
$this->DesNombre = "";
$this->DesPrecio = "";
$this->DesCondicion = "";
$this->DesInicia = "";
$this->DesTermina = "";
$this->DesPorcentaje = "";
$this->DesDescripcion = "";
$this->DesUsuario = 0;
$this->updated = "";
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
        return "CREATE TABLE `descuentos` (
  `DesID` int(11) NOT NULL AUTO_INCREMENT,
  `DesTipo` tinyint(1) NOT NULL,
  `DesObjetivo` varchar(20) NOT NULL,
  `DesProductos` varchar(100) NOT NULL,
  `DesCategorias` varchar(100) NOT NULL,
  `DesSubCat` varchar(100) NOT NULL,
  `DesNombre` varchar(100) NOT NULL,
  `DesPrecio` decimal(10,2) NOT NULL,
  `DesCondicion` varchar(100) NOT NULL,
  `DesInicia` date NOT NULL,
  `DesTermina` date NOT NULL,
  `DesPorcentaje` decimal(5,2) NOT NULL,
  `DesDescripcion` text NOT NULL,
  `DesUsuario` int(11) NOT NULL,
  `updated` tinyint(1) NOT NULL,
  `TiendaID` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`DesID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci";
    }
}
