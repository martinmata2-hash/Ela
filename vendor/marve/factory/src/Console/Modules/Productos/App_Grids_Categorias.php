<?php

namespace App\Grids;

class Categorias
{
    public static function grid($arguments = [])
    {
        return array(
            array(
                "title" => "ID",
                "name" => "CatID",
                "editable" => false,
                "width" => "20",
                "hidden" => true,
                "export" => false
            ),
            array(
                "title" => "Updated",
                "name" => "updated",
                "editable" => true,
                "width" => "20",
                "hidden" => true,
                "export" => false,
                "formatter" => "select",
                "edittype" => "select",
                "editoptions" => array("value" => "2:No"),
                "search" => false
            ),
            array(
                "title" => "Nombre",
                "name" => "CatNombre",
                "editable" => $arguments["editar"],
                "width" => "30",
                "export" => false,
                "link" => $arguments["link"],
                "linkoptions" => $arguments["options"]
            ),
        );
    }

    public static function subcat($arguments = [])
    {
        return array(
            array(
                "title" => "ID",
                "name" => "SubID",
                "editable" => false,
                "width" => "20",
                "hidden" => true,
                "export" => false
            ),
            array(
                "title" => "Updated",
                "name" => "updated",
                "editable" => true,
                "width" => "20",
                "hidden" => true,
                "export" => false,
                "formatter" => "select",
                "edittype" => "select",
                "editoptions" => array("value" => "2:No"),
                "search" => false
            ),
            array(
                "title" => "Nombre",
                "name" => "SubNombre",
                "editable" => $arguments["editar"],
                "width" => "30",
                "export" => false,
                "link" => $arguments["link"],
                "linkoptions" => $arguments["options"]
            ),
        );
    }

    public static function marcas($arguments = [])
    {
        return array(
            array(
                "title" => "ID",
                "name" => "MarID",
                "editable" => false,
                "width" => "20",
                "hidden" => true,
                "export" => false
            ),
            array(
                "title" => "Updated",
                "name" => "updated",
                "editable" => true,
                "width" => "20",
                "hidden" => true,
                "export" => false,
                "formatter" => "select",
                "edittype" => "select",
                "editoptions" => array("value" => "2:No"),
                "search" => false
            ),
            array(
                "title" => "Nombre",
                "name" => "MarNombre",
                "editable" => $arguments["editar"],
                "width" => "30",
                "export" => false,
                "link" => $arguments["link"],
                "linkoptions" => $arguments["options"]
            ),
        );
    }
}
