<?php 


namespace App\Middleware;

use App\Core\Access;
use Marve\Ela\Interfaces\MiddlewareInterface;
class Middleware implements MiddlewareInterface 
{
    public const MAP = [        
        'auth' => Access::class
    ];
    public static function resolve(string $key,array $data = [])
    {
        if($key == "")
        {
            return true;
        }
        
        $middleware = static::MAP[$key]?? false;
        if(!$middleware)
            return true;        
        return (new $middleware)->handle($data);
    }

}