<?php
namespace Marve\Ela\Interfaces;


interface MiddlewareHandleInterface
{    
    public function handle(array $auth);
}

