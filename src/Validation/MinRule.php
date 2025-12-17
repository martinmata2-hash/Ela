<?php 
namespace Marve\Ela\Validation;

use Marve\Ela\Core\Model;
use Marve\Ela\Validation\Interfaces\RuleInterface;

class MinRule implements RuleInterface
{
    protected $min;
    public function __construct(int $min = 0) 
    {
        $this->min = $min;
    }
    public function passes(mixed $value,  Model $modelo = null): bool 
    { 
        if(is_numeric((float)$value))
            return $value >= $this->min;
        elseif(is_string((string)$value))
            return strlen($value) >= $this->min;
        return false;
    }

    public function message(string $atribute, array &$messages = []): array 
    { 
        $messages[$atribute] = "El valor minimo debe ser $this->min";
        return $messages;
    }
}