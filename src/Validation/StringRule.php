<?php 
namespace Marve\Ela\Validation;

use Marve\Ela\Core\Model;
use Marve\Ela\Validation\Interfaces\RuleInterface;

class StringRule implements RuleInterface
{

    protected $min;
    public function __construct(int $min = 0) 
    {
        $this->min = $min;
    }
    public function passes(mixed $value, Model $modelo = null): bool 
    { 
        return is_string($value) && strlen($value) >= 4;
    }

    public function message(string $atribute, array &$messages = []): array 
    { 
        $messages[$atribute] = "EL campo debe contener solo letras";
        return $messages;
    }
    
}