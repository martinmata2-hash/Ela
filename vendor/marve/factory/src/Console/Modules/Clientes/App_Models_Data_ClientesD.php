<?php

namespace App\Models\Data;

use Marve\Ela\MySql\Interfaces\DataInterface;
use stdClass;

class ClientesD extends stdClass implements DataInterface
{
    /**
     * @var int
     *
     */ public $CliID;
    /**
     * @var string
     *
     */
    public $CliNombre;
    /**
     * @var string
     *
     */
    public $CliEmpresa;
    /**
     * @var string
     *
     */
    public $CliMunicipio;
    /**
     * @var string
     *
     */
    public $CliMunicipio2;
    /**
     * @var string
     *
     */
    public $CliColonia;
    /**
     * @var string
     *
     */
    public $CliColonia2;
    /**
     * @var string
     *
     */
    public $CliCalle;
    /**
     * @var string
     *
     */
    public $CliNumeroExt;
    /**
     * @var string
     *
     */
    public $CliNumeroInt;
    /**
     * @var string
     *
     */
    public $CliTelefono;
    /**
     * @var string
     *
     */
    public $CliCelular;
    /**
     * @var string
     *
     */
    public $CliEmail;
    /**
     * @var string
     *
     */
    public $CliNota;
    /**
     * @var string
     *
     */
    public $CliEstatus;
    /**
     * @var string
     *
     */
    public $CliRazon;
    /**
     * @var string
     *
     */
    public $CliRfc;
    /**
     * @var string
     *
     */
    public $CliRegimen;
    /**
     * @var string
     *
     */
    public $CliEstado;
    /**
     * @var string
     *
     */
    public $CliCp;
    /**
     * @var int
     *
     */ public $CliCredito;
    /**
     * @var string
     *
     */
    public $CliCodigo;
    /**
     * @var int
     *
     */ public $CliPuntos;
    /**
     * @var string
     *
     */
    public $CliPais;
    /**
     * @var string
     *
     */
    public $CliFechaNacimiento;
    /**
     * @var string
     *
     */
    public $CliSexo;
    /**
     * @var string
     *
     */
    public $CliNacionalidad;
    /**
     * @var string
     *
     */
    public $CliOcupacion;
    /**
     * @var string
     *
     */
    public $CliCivil;
    /**
     * @var string
     *
     */
    public $CliLugarNacimiento;
    /**
     * @var string
     *
     */
    public $CliReligion;
    /**
     * @var string
     *
     */
    public $CliReferencias;
    /**
     * @var int
     *
     */ public $CliPrecio;
    /**
     * @var string
     *
     */
    public $CliPorciento;
    /**
     * @var string
     *
     */
    public $CliUsoCFDI;
    /**
     * @var string
     *
     */
    public $CliRuta;
    /**
     * @var int
     *
     */ public $updated;
    /**
     * @var string
     *
     */
    public $CliContacto;
    /**
     * @var int
     *
     */ public $CliCobrador;
    /**
     * @var string
     *
     */
    public $CliDirecciones;

    public function __construct($datos = null)
    {
        try {
            if ($datos == null) {
                $this->CliID = 0;
                $this->CliNombre = "";
                $this->CliEmpresa = "";
                $this->CliMunicipio = "";
                $this->CliMunicipio2 = "";
                $this->CliColonia = "";
                $this->CliColonia2 = "";
                $this->CliCalle = "";
                $this->CliNumeroExt = "";
                $this->CliNumeroInt = "";
                $this->CliTelefono = "";
                $this->CliCelular = "";
                $this->CliEmail = "";
                $this->CliNota = "";
                $this->CliEstatus = "";
                $this->CliRazon = "";
                $this->CliRfc = "";
                $this->CliRegimen = "";
                $this->CliEstado = "";
                $this->CliCp = "";
                $this->CliCredito = 0;
                $this->CliCodigo = "";
                $this->CliPuntos = 0;
                $this->CliPais = "";
                $this->CliFechaNacimiento = "";
                $this->CliSexo = "";
                $this->CliNacionalidad = "";
                $this->CliOcupacion = "";
                $this->CliCivil = "";
                $this->CliLugarNacimiento = "";
                $this->CliReligion = "";
                $this->CliReferencias = "";
                $this->CliPrecio = 0;
                $this->CliPorciento = "";
                $this->CliUsoCFDI = "";
                $this->CliRuta = "";
                $this->updated = 0;
                $this->CliContacto = "";
                $this->CliCobrador = 0;
                $this->CliDirecciones = "";
            } else {
                foreach ($datos as $k => $v) {
                    $this->$k = $v;
                }
            }
        } catch (\Exception $e) {
        }
    }
    public function sql()
    {
        return "CREATE TABLE IF NOT EXISTS `clientes` (
  `CliID` int(11) NOT NULL AUTO_INCREMENT,
  `CliNombre` tinytext NOT NULL,
  `CliEmpresa` tinytext NOT NULL,
  `CliMunicipio` tinytext DEFAULT NULL,
  `CliMunicipio2` tinytext DEFAULT NULL,
  `CliColonia` tinytext NOT NULL,
  `CliColonia2` tinytext NOT NULL,
  `CliCalle` tinytext NOT NULL,
  `CliNumeroExt` tinytext NOT NULL,
  `CliNumeroInt` tinytext DEFAULT NULL,
  `CliTelefono` tinytext NOT NULL,
  `CliCelular` tinytext NOT NULL,
  `CliEmail` tinytext NOT NULL,
  `CliNota` tinytext NOT NULL,
  `CliEstatus` tinyint(1) NOT NULL,
  `CliRazon` varchar(200) NOT NULL,
  `CliRfc` varchar(15) NOT NULL,
  `CliRegimen` varchar(10) NOT NULL,
  `CliEstado` tinytext NOT NULL,
  `CliCp` varchar(10) NOT NULL,
  `CliCredito` int(11) NOT NULL DEFAULT 0 COMMENT 'Cantidad maxima a credito',
  `CliCodigo` varchar(13) NOT NULL COMMENT 'Codigo para tarjeta',
  `CliPuntos` int(11) NOT NULL COMMENT 'Puntos acomulados',
  `CliPais` varchar(5) NOT NULL,
  `CliFechaNacimiento` date NOT NULL,
  `CliSexo` varchar(1) NOT NULL,
  `CliNacionalidad` tinytext NOT NULL,
  `CliOcupacion` tinytext NOT NULL,
  `CliCivil` varchar(1) NOT NULL,
  `CliLugarNacimiento` tinytext NOT NULL,
  `CliReligion` tinytext NOT NULL,
  `CliReferencias` tinytext NOT NULL,
  `CliPrecio` int(3) NOT NULL,
  `CliPorciento` decimal(5,2) NOT NULL,
  `CliUsoCFDI` varchar(10) NOT NULL,
  `CliRuta` tinyint(4) NOT NULL,
  `updated` int(3) NOT NULL,
  `CliContacto` varchar(100) NOT NULL,
  `CliCobrador` int(11) NOT NULL,
  `CliDirecciones` text NOT NULL,
  PRIMARY KEY (`CliID`),
  UNIQUE KEY `Nombre_unico` (`CliNombre`) USING HASH
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci";
    }
}
