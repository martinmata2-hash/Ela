<?php
/**
 * Interface para clases Middleware
 */
namespace Marve\Ela\Interfaces;


interface MiddlewareInterface
{
    
    public static function resolve(string $key,array $data);
}
