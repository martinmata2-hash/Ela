<?php

use App\Core\Login;
use Marve\Ela\Core\CurrentUser;

include_once 'vendor/autoload.php';

$LOGIN = new Login();
if ($LOGIN->isLoged()) 
{
    if(CurrentUser::isAdmin())
        header("Location: /Dashboard/Ventas");
    else 
        header("Location: /Dashboard/Clientes");
} 
else 
{
    header("Location: /Dashboard/Login");
}
