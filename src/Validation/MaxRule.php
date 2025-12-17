<?php 
namespace Marve\Ela\Validation;

use Marve\Ela\Core\Model;
use Marve\Ela\Validation\Interfaces\RuleInterface;

class MaxRule implements RuleInterface
{
    
    protected $max;
    public function __construct(int $max = 0) 
    {
        $this->max = $max;
    }
    public function passes(mixed $value,  Model $model = null): bool 
    { 
        if(is_numeric((float)$value))
            return $value <= $this->max;
        elseif(is_string((string)$value))
            return strlen($value) >= $this->max;
        return false;
    }

    public function message(string $atribute, array &$messages = []): array 
    { 
        $messages[$atribute] = "El valor maximo debe ser $this->max";
        return $messages;
    }
}