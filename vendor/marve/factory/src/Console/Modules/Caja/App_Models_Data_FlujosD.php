<?php
namespace App\Models\Data;
use Marve\Ela\MySql\Interfaces\DataInterface;
use stdClass;

class FlujosD extends stdClass implements DataInterface
{
    /**
* @var int
*
*/public $FluID;
/**
* @var int
*
*/public $FluUsuario;
/**
* @var int
*
*/public $FluCantidad;
/**
* @var string
*
*/
public $FluMetodo;
/**
* @var string
*
*/
public $FluCodigo;
/**
* @var string
*
*/
public $FluDescripcion;
/**
* @var string
*
*/
public $FluFecha;
/**
* @var int
*
*/public $FluRelacion;
/**
* @var string
*
*/
public $udpated;
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
                $this->FluID = 0;
$this->FluUsuario = 0;
$this->FluCantidad = 0;
$this->FluMetodo = "";
$this->FluCodigo = "";
$this->FluDescripcion = "";
$this->FluFecha = "";
$this->FluRelacion = 0;
$this->udpated = "";
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
        return "CREATE TABLE `flujomonetario` (
  `FluID` int(11) NOT NULL AUTO_INCREMENT,
  `FluUsuario` int(11) NOT NULL,
  `FluCantidad` int(11) NOT NULL,
  `FluMetodo` varchar(4) NOT NULL DEFAULT '01',
  `FluCodigo` tinyint(4) NOT NULL COMMENT '1:ventas 3:devoluciones 5: salidas 6:entradas 7 Pagos',
  `FluDescripcion` varchar(100) NOT NULL,
  `FluFecha` datetime NOT NULL,
  `FluRelacion` int(11) NOT NULL,
  `udpated` tinyint(1) NOT NULL,
  `TiendaID` int(11) NOT NULL,
  PRIMARY KEY (`FluID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Flujo monetario'";
    }
}
