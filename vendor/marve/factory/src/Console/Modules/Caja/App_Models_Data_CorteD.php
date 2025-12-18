<?php
namespace App\Models\Data;
use Marve\Ela\MySql\Interfaces\DataInterface;
use stdClass;

class CorteD extends stdClass implements DataInterface
{
    /**
* @var int
*
*/public $CorID;
/**
* @var int
*
*/public $CorCaja;
/**
* @var int
*
*/public $CorUsuario;
/**
* @var string
*
*/
public $CorInicio;
/**
* @var string
*
*/
public $CorFin;
/**
* @var string
*
*/
public $CorEntradas;
/**
* @var string
*
*/
public $CorSalidas;
/**
* @var string
*
*/
public $updated;
 
    public function __construct($datos = null)
    {
        try
        {
            if ($datos == null)
            {
                $this->CorID = 0;
$this->CorCaja = 0;
$this->CorUsuario = 0;
$this->CorInicio = "";
$this->CorFin = "";
$this->CorEntradas = "";
$this->CorSalidas = "";
$this->updated = "";

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
        return "CREATE TABLE `cortes` (
  `CorID` int(11) NOT NULL AUTO_INCREMENT,
  `CorCaja` int(11) NOT NULL,
  `CorUsuario` int(11) NOT NULL,
  `CorInicio` datetime NOT NULL,
  `CorFin` datetime NOT NULL,
  `CorEntradas` decimal(10,2) NOT NULL,
  `CorSalidas` decimal(10,2) NOT NULL,
  `updated` tinyint(1) NOT NULL,
  PRIMARY KEY (`CorID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci";
    }
}
