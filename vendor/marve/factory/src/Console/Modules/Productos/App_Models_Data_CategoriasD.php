<?php
namespace App\Models\Data;
use Marve\Ela\MySql\Interfaces\DataInterface;
use stdClass;

class CategoriasD extends stdClass implements DataInterface
{
    /**
* @var int
*
*/public $CatID;
/**
* @var string
*
*/
public $CatNombre;
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
                $this->CatID = 0;
$this->CatNombre = "";
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
        return "CREATE TABLE `categorias` (
  `CatID` int(11) NOT NULL AUTO_INCREMENT,
  `CatNombre` varchar(100) NOT NULL,
  `updated` int(3) NOT NULL,
  PRIMARY KEY (`CatID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
    }
}
