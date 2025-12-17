<?php
/**
 * Router para MVC 
 */
namespace Marve\Ela\Core;

use App\Core\MainPage;
use App\Middleware\Middleware;

global $params;
class Router
{
    protected $routes = [];
   
    /**
     * Summary of add
     * @param string $method
     * @param string $uri
     * @param string $controller
     * @return static
     */
    public function add($method, $uri, $controller)
    {
        $this->routes[] = [
            'uri' => $uri,
            'controller' => $controller,
            'method' => $method,
            'middleware' => "",
            'data'=> []
        ];

        return $this;
    }

    /**
     * Summary of get
     * @param string $uri
     * @param string $controller
     * @return Router
     */
    public function get($uri, $controller)
    {
        return $this->add('GET', $uri, $controller);
    }

    /**
     * Summary of post
     * @param string $uri
     * @param string $controller
     * @return Router
     */
    public function post($uri, $controller)
    {
        return $this->add('POST', $uri, $controller);
    }

    /**
     * Summary of delete
     * @param string $uri
     * @param string $controller
     * @return Router
     */
    public function delete($uri, $controller)
    {
        return $this->add('DELETE', $uri, $controller);
    }

    public function patch($uri, $controller)
    {
        return $this->add('PATCH', $uri, $controller);
    }

    public function put($uri, $controller)
    {
        return $this->add('PUT', $uri, $controller);
    }

    /**
     * Summary of middleware
     * @param mixed $key
     * @param mixed $data
     * @return static
     */
    public function middleware($key,$data)
    {
        $this->routes[array_key_last($this->routes)]['middleware'] = $key;
        $this->routes[array_key_last($this->routes)]['data'] = $data;
        return $this;
    }

    public function route(&$uri, $method)
    {

        foreach ($this->routes as $route) 
        {
            $this->params($route['uri'],$uri);    
            if ($route['uri'] === $uri && $route['method'] === strtoupper($method))
            {
                if ($route["middleware"] == "pagina" && $route["data"]["pagina"] == "propia")
                    return require ($route['controller']);
                //Middleware debe ser implementado en App/Middleware/Middleware
                elseif (Middleware::resolve($route["middleware"], $route["data"]))
                {
                    if (@class_exists("App\\Core\\MainPage"))
                    {
                        $PAGINA = new MainPage($uri, $route['controller']);
                        return $PAGINA->render();
                    }
                    return require ($route['controller']);
                }                
                else 
                    $this->abort("401");
            }
            
        }

        $this->abort();
    }

    private function params(&$route, &$uri)
    {
        global $params;
         // will store all the parameters value in this array
         $params = [];
         $paramMatches = [];
 
         // finding if there is any {?} parameter in $route
         preg_match_all("/(?<={).+?(?=})/", $route, $paramMatches);                   
         if (empty($paramMatches[0]))
         {             
             return;
         }
         else
         {
            $temp = explode("/",$route);            
            $tempuri = explode("/",$uri);            
            if($temp[1] == $tempuri[1] && count($temp) == count($tempuri))
            {
                $count = 2;                
                foreach ($paramMatches[0] as $key => $value) 
                {
                    $params[$value] = $tempuri[$count++];                   
                }
                $route = "/".$temp[1];
                $uri = "/".$tempuri[1];                
            }
         }
             
    }

    protected function abort($code = 404)
    {
        http_response_code($code);
        require ("App/Views/{$code}.php");
        die();
    }
}
