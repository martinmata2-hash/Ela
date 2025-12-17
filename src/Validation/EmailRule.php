<?php 
namespace Marve\Ela\Validation;

use Marve\Ela\Core\Model;
use Marve\Ela\Validation\Interfaces\RuleInterface;

class EmailRule implements RuleInterface
{

    public function passes(mixed $value, Model $modelo = null): bool 
    { 
        return DirectValidator::Email($value);
    }

    public function message(string $atribute, array &$messages = []): array 
    { 
        $messages[$atribute] = "Email mal formado o invalido";
        return $messages;
    }
    
}