<?php
namespace App\Models\Data;
use Marve\Ela\MySql\Interfaces\DataInterface;
use stdClass;

class AccessD extends stdClass implements DataInterface
{
    /**
* @var int
*
*/public $PusID;
/**
* @var int
*
*/public $PusUsuario;
/**
* @var string
*
*/
public $PusPermisos;
/**
* @var int
*
*/public $deleted;

 
    public function __construct($datos = null)
    {
        try
        {
            if ($datos == null)
            {
                $this->PusID = 0;
                $this->PusUsuario = 0;
                $this->PusPermisos = "";
                $this->deleted = 0;                
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
        return "CREATE TABLE `permisos` (
            `PusID` int(11) NOT NULL AUTO_INCREMENT,
            `PusUsuario` int(11) NOT NULL,
            `PusPermisos` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
            `deleted` int(1) NOT NULL,           
            PRIMARY KEY (`PusID`)
          ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
          
          INSERT INTO `permisos` (`PusID`, `PusUsuario`, `PusPermisos`, `deleted`) VALUES
            (1, 1, '1,2,3,18,17,4,5,6,7,8,14,9,10,11,12,13,16,19,20,21,22', 0),
            (2, 2, '2,3', 0);";
    }
}