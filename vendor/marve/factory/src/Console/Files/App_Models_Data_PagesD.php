<?php
namespace App\Models\Data;

use Marve\Ela\MySql\Interfaces\DataInterface;
use stdClass;

class PagesD extends stdClass implements DataInterface
{
    /**
* @var int
*
*/public $ArcID;
/**
* @var string
*
*/
public $ArcNombre;
/**
* @var string
*
*/
public $ArcPath;
/**
* @var string
*
*/
public $ArcIcon;
/**
* @var int
*
*/public $ArcModulo;
/**
* @var int
*
*/public $ArcOrden;
/**
* @var int
*
*/public $ArcSubModulo;
/**
* @var string
*
*/
public $lastupdate;
 
    public function __construct($datos = null)
    {
        try
        {
            if ($datos == null)
            {
                $this->ArcID = 0;
$this->ArcNombre = "";
$this->ArcPath = "";
$this->ArcIcon = "";
$this->ArcModulo = 0;
$this->ArcOrden = 0;
$this->ArcSubModulo = 0;
$this->lastupdate = "";

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
        return "CREATE TABLE `archivos` (
        `ArcID` int(11) NOT NULL AUTO_INCREMENT,
        `ArcNombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
        `ArcPath` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
        `ArcIcon` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
        `ArcModulo` int(11) NOT NULL,
        `ArcOrden` int(11) NOT NULL,
        `ArcSubModulo` int(11) NOT NULL,
        `updated` int(1) NOT NULL,
        PRIMARY KEY (`ArcID`)
        ) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
        INSERT INTO `archivos` (`ArcID`, `ArcNombre`, `ArcPath`, `ArcIcon`, `ArcModulo`, `ArcOrden`, `ArcSubModulo`, `updated`) VALUES
        (1, 'Admin', 'Admin', 'user-1', 2, 1, 0, 0),        
        (2, 'Clientes', 'Clientes', 'man-1', 3, 1, 0, 0),
        (3, 'Productos', 'Productos', 'document-saved-1', 3, 2, 0, 0),
        (4, 'Proveedores', 'Proveedores', 'user-1', 3, 3, 0, 0),
        (5, 'Categorias', 'Categorias', 'document-saved-1', 3, 3, 0, 0),
        (6, 'Ajustes', 'Ajustes-Catalogos', 'settings-1', 3, 5, 0, 0),
        (7, 'Ventas', 'Ventas', 'shopping-cart-1', 4, 1, 0, 0),
        (8, 'Cotizaciones', 'Cotizaciones', 'dollar-sign-1', 4, 2, 0, 0),
        (9, 'Abonos', 'Creditos', 'credit-card-1', 4, 3, 0, 0),
        (10, 'Prestamos', 'Prestamos', 'dollar-sign-1', 4, 4, 0, 0),
        (11, 'Caja', 'Caja', 'money-box-1', 4, 5, 0, 0),
        (12, 'Ajustes', 'Ajustes-Ventas', 'settings-1', 4, 6, 0, 0),
        (13, 'Descuentos', 'Descuentos', 'sales-up-1', 4, 7, 0, 0),
        (14, 'Rutas', 'Rutas', 'delivery-truck-1', 4, 8, 0, 0),
        (15, 'Compras', 'Compras', 'add-1', 5, 1, 0, 0),
        (16, 'Movimientos', 'Salidas', 'minus-1', 5, 2, 0, 0),
        (17, 'Entradas', 'Entradas', 'add-1', 5, 3, 0, 0),        
        (18, 'Inventarios', 'Inventario', 'document-saved-1', 5, 5, 0, 0),
        (19, 'Datos', 'MisDatos', 'user-1', 6, 1, 0, 0),
        (20, 'Facturas', 'Facturas', 'chart-1', 6, 2, 0, 0),
        (21, 'Ventas', 'Reportes-Ventas', 'pie-chart-1', 6, 3, 0, 0),
        (22, 'Compras', 'Reportes-Compras', 'chart-1', 6, 4, 0, 0),
        (23, 'Salidas', 'Reportes-Salidas', 'arrow-left-1', 6, 5, 0, 0),        
        (24, 'Actividad', 'Actividad', 'arrow-left-1', 2, 5, 0, 0),
        (25, 'Monetario', 'Reportes-Flujos', 'dollar-sign-1', 6, 1, 0, 0);";
    }
}
