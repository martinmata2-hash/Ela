<?php
namespace Marve\Ela\Core;

class App
{
    
    public Router $router;


    public function __construct()
    {
            
        $this->router = new Router();            
        Session::setCsrf();
    }

    public function run()
    {
        $uri = str_replace("/Dashboard","",parse_url($_SERVER['REQUEST_URI'])['path']);
        $method = $_SERVER['REQUEST_METHOD'];
        echo $this->router->route($uri, $method);
    }
}