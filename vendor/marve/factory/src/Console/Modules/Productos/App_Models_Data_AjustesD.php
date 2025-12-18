<?php

namespace App\Models\Data;

use Marve\Ela\MySql\Interfaces\DataInterface;
use stdClass;

class AjustesD extends stdClass implements DataInterface
{
    /**
     * @var int
     *
     */ public $AjuID;
    /**
     * @var string
     *
     */
    public $AjuDescripcion;
    /**
     * @var string
     *
     */
    public $AjuNombre;
    /**
     * @var string
     *
     */
    public $AjuValor;
    /**
     * @var int
     *
     */ public $AjuRol;
    /**
     * @var int
     *
     */ public $AjuTipo;

    public function __construct($datos = null)
    {
        try {
            if ($datos == null) {
                $this->AjuID = 0;
                $this->AjuDescripcion = "";
                $this->AjuNombre = "";
                $this->AjuValor = "";
                $this->AjuRol = 0;
                $this->AjuTipo = 0;
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
        return "CREATE TABLE IF NOT EXISTS `ajustes` (
  `AjuID` int(11) NOT NULL AUTO_INCREMENT,
  `AjuDescripcion` tinytext NOT NULL,
  `AjuNombre` varchar(40) NOT NULL COMMENT 'NOmbre Unico',
  `AjuValor` text NOT NULL,
  `AjuRol` int(11) NOT NULL COMMENT 'Quien puede modificarlo',
  `AjuTipo` int(11) NOT NULL COMMENT 'Numerico o Texto',
  PRIMARY KEY (`AjuID`),
  UNIQUE KEY `Nombre_unico` (`AjuNombre`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci";
    }
}
