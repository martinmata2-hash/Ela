<?php

namespace App\Models\Data;

use Marve\Ela\MySql\Interfaces\DataInterface;
use stdClass;

class InventariosD extends stdClass implements DataInterface
{
    /**
     * @var int
     *
     */ public $InvID;
    /**
     * @var int
     *
     */ public $InvProducto;
    /**
     * @var string
     *
     */
    public $InvCantidad;
    /**
     * @var int
     *
     */ public $updated;
    /**
     * @var int
     *
     */ public $TiendaID;

    public function __construct($datos = null)
    {
        try {
            if ($datos == null) {
                $this->InvID = 0;
                $this->InvProducto = 0;
                $this->InvCantidad = "";
                $this->updated = 0;
                $this->TiendaID = 0;
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
        return "CREATE TABLE IF NOT EXISTS `inventarios` (
  `InvID` int(11) NOT NULL AUTO_INCREMENT,
  `InvProducto` int(11) NOT NULL,
  `InvCantidad` decimal(10,2) NOT NULL,
  `updated` int(3) NOT NULL,
  `TiendaID` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`InvID`),
  UNIQUE KEY `Producto` (`InvProducto`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci";
    }
}
