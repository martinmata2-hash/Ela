<?php 
namespace Marve\Ela\Validation;

use Marve\Ela\Core\Model;
use Marve\Ela\Validation\Interfaces\RuleInterface;

class NumberRule implements RuleInterface
{

    public function passes(mixed $value, Model $modelo = null): bool 
    { 
        return is_numeric($value);
    }

    public function message(string $atribute, array &$messages = []): array 
    { 
        $messages[$atribute] = "EL campo debe de ser Numero";
        return $messages;
    }
    
}