<?php 
namespace Marve\Ela\Validation;

use Marve\Ela\Core\Model;
use Marve\Ela\Validation\Interfaces\RuleInterface;

class AlphanumericRule implements RuleInterface
{

    protected $min;
    public function __construct(int $min = 0) 
    {
        $this->min = $min;
    }
    public function passes(mixed $value, Model $modelo = null): bool 
    {         
        return DirectValidator::User($value,$this->min);
    }

    public function message(string $atribute, array &$messages = []): array 
    { 
        $messages[$atribute] = "Contiene caracteres no admitidos";
        return $messages;
    }
    
}