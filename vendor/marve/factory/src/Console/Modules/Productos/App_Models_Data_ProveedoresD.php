<?php
namespace App\Models\Data;
use Marve\Ela\MySql\Interfaces\DataInterface;
use stdClass;

class ProveedoresD extends stdClass implements DataInterface
{
    /**
* @var int
*
*/public $ProvID;
/**
* @var string
*
*/
public $ProvEmpresa;
/**
* @var string
*
*/
public $ProvContacto;
/**
* @var string
*
*/
public $ProvRazon;
/**
* @var string
*
*/
public $ProvPais;
/**
* @var string
*
*/
public $ProvEstado;
/**
* @var string
*
*/
public $ProvMunicipio;
/**
* @var string
*
*/
public $ProvColonia;
/**
* @var string
*
*/
public $ProvMunicipio2;
/**
* @var string
*
*/
public $ProvColonia2;
/**
* @var string
*
*/
public $ProvCalle;
/**
* @var string
*
*/
public $ProvNumeroInt;
/**
* @var string
*
*/
public $ProvNumeroExt;
/**
* @var string
*
*/
public $ProvCp;
/**
* @var string
*
*/
public $ProvEmail;
/**
* @var string
*
*/
public $ProvCelular;
/**
* @var string
*
*/
public $ProvTelefono;
/**
* @var string
*
*/
public $ProvRfc;
/**
* @var string
*
*/
public $ProvRegimen;
/**
* @var string
*
*/
public $ProvSeguimiento;
/**
* @var string
*
*/
public $ProvCobranza;
/**
* @var string
*
*/
public $ProvNota;
/**
* @var string
*
*/
public $ProvContactoTelefono;
/**
* @var string
*
*/
public $ProvEstatus;
/**
* @var string
*
*/
public $ProvFecha;
/**
* @var int
*
*/public $ProvUsuario;
/**
* @var int
*
*/public $updated;
 
    public function __construct($datos = null)
    {
        try
        {
            if ($datos == null)
            {
                $this->ProvID = 0;
$this->ProvEmpresa = "";
$this->ProvContacto = "";
$this->ProvRazon = "";
$this->ProvPais = "";
$this->ProvEstado = "";
$this->ProvMunicipio = "";
$this->ProvColonia = "";
$this->ProvMunicipio2 = "";
$this->ProvColonia2 = "";
$this->ProvCalle = "";
$this->ProvNumeroInt = "";
$this->ProvNumeroExt = "";
$this->ProvCp = "";
$this->ProvEmail = "";
$this->ProvCelular = "";
$this->ProvTelefono = "";
$this->ProvRfc = "";
$this->ProvRegimen = "";
$this->ProvSeguimiento = "";
$this->ProvCobranza = "";
$this->ProvNota = "";
$this->ProvContactoTelefono = "";
$this->ProvEstatus = "";
$this->ProvFecha = "";
$this->ProvUsuario = 0;
$this->updated = 0;

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
        return "CREATE TABLE `proveedores` (
  `ProvID` int(11) NOT NULL AUTO_INCREMENT,
  `ProvEmpresa` varchar(100) NOT NULL,
  `ProvContacto` varchar(100) NOT NULL,
  `ProvRazon` varchar(100) NOT NULL,
  `ProvPais` varchar(3) NOT NULL,
  `ProvEstado` varchar(6) NOT NULL,
  `ProvMunicipio` varchar(6) NOT NULL,
  `ProvColonia` varchar(6) NOT NULL,
  `ProvMunicipio2` varchar(100) NOT NULL,
  `ProvColonia2` varchar(100) NOT NULL,
  `ProvCalle` varchar(100) NOT NULL,
  `ProvNumeroInt` varchar(20) NOT NULL,
  `ProvNumeroExt` varchar(20) NOT NULL,
  `ProvCp` varchar(10) NOT NULL,
  `ProvEmail` varchar(100) NOT NULL,
  `ProvCelular` varchar(10) NOT NULL,
  `ProvTelefono` varchar(10) NOT NULL,
  `ProvRfc` varchar(15) NOT NULL,
  `ProvRegimen` varchar(6) NOT NULL,
  `ProvSeguimiento` datetime NOT NULL,
  `ProvCobranza` varchar(10) NOT NULL,
  `ProvNota` text NOT NULL,
  `ProvContactoTelefono` varchar(10) NOT NULL,
  `ProvEstatus` tinyint(4) NOT NULL,
  `ProvFecha` datetime NOT NULL,
  `ProvUsuario` int(11) NOT NULL,
  `updated` int(3) NOT NULL,
  PRIMARY KEY (`ProvID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci COMMENT='Lista de Proveedores Empresas'";
    }
}
