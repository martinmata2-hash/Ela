<?php
namespace App\Models\Data;
use Marve\Ela\MySql\Interfaces\DataInterface;
use stdClass;

class CajasD extends stdClass implements DataInterface
{
    /**
* @var int
*
*/public $CajID;
/**
* @var int
*
*/public $CajUsuario;
/**
* @var string
*
*/
public $CajFecha;
/**
* @var string
*
*/
public $CajCantidad;
/**
* @var int
*
*/public $CajTipo;
/**
* @var string
*
*/
public $updated;
/**
* @var int
*
*/public $CajClave;
/**
* @var string
*
*/
public $CajDescripcion;
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
                $this->CajID = 0;
$this->CajUsuario = 0;
$this->CajFecha = "";
$this->CajCantidad = "";
$this->CajTipo = 0;
$this->updated = "";
$this->CajClave = 0;
$this->CajDescripcion = "";
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
        return "CREATE TABLE `cajas` (
  `CajID` int(11) NOT NULL AUTO_INCREMENT,
  `CajUsuario` int(11) NOT NULL,
  `CajFecha` datetime NOT NULL,
  `CajCantidad` decimal(10,2) NOT NULL,
  `CajTipo` int(2) NOT NULL,
  `updated` tinyint(1) NOT NULL,
  `CajClave` int(11) NOT NULL,
  `CajDescripcion` tinytext NOT NULL,
  `TiendaID` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`CajID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci";
    }
}
