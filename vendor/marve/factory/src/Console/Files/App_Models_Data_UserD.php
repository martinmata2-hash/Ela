<?php
namespace App\Models\Data;
use Marve\Ela\MySql\Interfaces\DataInterface;
use stdClass;

class UserD extends stdClass implements DataInterface
{
    /**
* @var int
*
*/public $UsuID;
/**
* @var int
*
*/public $UsuCliente;
/**
* @var string
*
*/
public $UsuCodigo;
/**
* @var string
*
*/
public $UsuNombre;
/**
* @var string
*
*/
public $UsuUsuario;
/**
* @var string
*
*/
public $UsuClave;
/**
* @var string
*
*/
public $UsuRol;
/**
* @var string
*
*/
public $UsuEmail;
/**
* @var string
*
*/
public $UsuCelular;
/**
* @var string
*
*/
public $UsuToken;
/**
* @var string
*
*/
public $UsuBd;
/**
* @var string
*
*/
public $UsuLenguaje;
/**
* @var string
*
*/
public $UsuActivo;
/**
* @var string
*
*/
public $UsuEmpresa;
/**
* @var string
*
*/
public $updated;
/**
* @var string
*
*/
public $lastupdate;
/**
* @var string
*
*/
public $UsuClavePAC;
/**
* @var string
*
*/
public $UsuUsuarioPAC;
/**
* @var string
*
*/
public $token;
/**
* @var int
*
*/public $expiration;
/**
* @var string
*
*/
public $session_id;
 
    public function __construct($datos = null)
    {
        try
        {
            if ($datos == null)
            {
                $this->UsuID = 0;
$this->UsuCliente = 0;
$this->UsuCodigo = "";
$this->UsuNombre = "";
$this->UsuUsuario = "";
$this->UsuClave = "";
$this->UsuRol = "";
$this->UsuEmail = "";
$this->UsuCelular = "";
$this->UsuToken = "";
$this->UsuBd = "";
$this->UsuLenguaje = "";
$this->UsuActivo = "";
$this->UsuEmpresa = "";
$this->updated = "";
$this->lastupdate = "";
$this->UsuClavePAC = "";
$this->UsuUsuarioPAC = "";
$this->token = "";
$this->expiration = 0;
$this->session_id = "";

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
        return "CREATE TABLE `usuarios` (
  `UsuID` int(11) NOT NULL AUTO_INCREMENT,
  `UsuCliente` int(11) NOT NULL COMMENT 'id del Cliente',
  `UsuCodigo` varchar(12) NOT NULL,
  `UsuNombre` tinytext NOT NULL,
  `UsuUsuario` varchar(48) NOT NULL,
  `UsuClave` varchar(48) NOT NULL,
  `UsuRol` tinyint(4) unsigned NOT NULL,
  `UsuEmail` tinytext NOT NULL,
  `UsuCelular` varchar(14) NOT NULL,
  `UsuToken` varchar(45) NOT NULL,
  `UsuBd` varchar(40) NOT NULL,
  `UsuLenguaje` varchar(3) NOT NULL,
  `UsuActivo` tinyint(1) NOT NULL,
  `UsuEmpresa` varchar(50) NOT NULL,
  `updated` tinyint(1) NOT NULL,
  `lastupdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `UsuClavePAC` tinytext NOT NULL,
  `UsuUsuarioPAC` tinytext NOT NULL,
  `token` varchar(45) NOT NULL,
  `expiration` int(11) DEFAULT NULL,
  `session_id` varchar(40) NOT NULL,
  PRIMARY KEY (`UsuID`),
  UNIQUE KEY `UsuUsuario` (`UsuUsuario`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci";
    }
}
