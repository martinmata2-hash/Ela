<?php
namespace App\Models\Data;
use Marve\Ela\MySql\Interfaces\DataInterface;
use stdClass;

class ZincD extends stdClass implements DataInterface
{
    /**
* @var int
*
*/public $ZinID;
/**
* @var string
*
*/
public $ZInClass;
/**
* @var string
*
*/
public $created_at;
 
    public function __construct($datos = null)
    {
        try
        {
            if ($datos == null)
            {
                $this->ZinID = 0;
$this->ZInClass = "";
$this->created_at = "";

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
        return "CREATE TABLE `zinc` (
  `ZinID` int(11) NOT NULL AUTO_INCREMENT,
  `ZInClass` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`ZinID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
    }
}
