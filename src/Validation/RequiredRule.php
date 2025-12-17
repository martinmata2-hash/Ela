<?php 
namespace Marve\Ela\Validation;

use Marve\Ela\Core\Model;
use Marve\Ela\Validation\Interfaces\RuleInterface;

class RequiredRule implements RuleInterface
{

    public function passes(mixed $value, Model $modelo = null): bool 
    { 
        return isset($value) && trim((string)$value) !== "";
    }

    public function message(string $atribute, array &$messages = []): array 
    { 
        $messages[$atribute] = "El campo es requerido";
        return $messages;
    }
    
}