<?php

namespace App\Grids;

class Clientes
{
    public static function grid($arguments = [])
    {
        return array(
            array(
                "title" => "ID",
                "name" => "CliID",
                "editable" => false,
                "width" => "10",
                "align" => "center",
                "export" => false,
                "hidden" => true
            ),
            array(
                "title" => "ID",
                "name" => "ID",
                "editable" => false,
                "width" => "10",
                "align" => "center",
                "export" => false,
                "link" => $arguments["link"],
                "linkoptions" => $arguments["options"]
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
            /*
            array(
                "title" => "Codigo",
                "name" => "CliCodigo",
                "editable" => $arguments["editar"],
                "width" => "10",
                "align" => "left"
            ),
            */
            array(
                "title" => "Razon Social",
                "name" => "CliNombre",
                "editable" => $arguments["editar"],
                "width" => "30"
            ),
            /*
            array(
                "title" => "Monedero",
                "name" => "CliPuntos",
                "editable" => false,
                "width" => "10",
                "align" => "center"
            ),
            */
            array(
                "title" => "Credito",
                "name" => "CliCredito",
                "editable" => $arguments["editar"],
                "width" => "10",
                "align" => "center"
            ),
            array(
                "title" => "Telefono",
                "name" => "CliTelefono",
                "editable" => false,
                "width" => "20",
                "align" => "center"
            ),
            array(
                "title" => "EMail",
                "name" => "CliEmail",
                "editable" => $arguments["editar"],
                "width" => "20",
                "align" => "right"
            ),
            /*
            array(
                "title" => "Ruta",
                "name" => "CliRuta",
                "editable" => $arguments["editar"],
                "width" => "10",
                "align" => "center",
                "formatter" => "select",
                "edittype" => "select",
                "editoptions" => array("value" => "-1:seleciona;" . $arguments["rutas"]),
                "op" => "eq",
                "searchoptions" => array("value" => "-1:seleciona;" . $arguments["rutas"]),
                "stype" => "select"
            )
                */
        );
    }
}
