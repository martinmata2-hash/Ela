<?php

use App\Core\Login;
use Marve\Ela\Core\App;


@session_start();
set_include_path(get_include_path().PATH_SEPARATOR.realpath(dirname(__FILE__)."/../"));
$inicio = "../";
global $params;
include_once "vendor/autoload.php";

$APP = new App();
$LOGED = new Login();

require $inicio.'App/Core/routes.php';

$APP->run();
