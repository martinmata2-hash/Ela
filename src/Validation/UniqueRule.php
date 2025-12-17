<?php 
namespace Marve\Ela\Validation;

use Marve\Ela\Core\Model;
use Marve\Ela\Validation\Interfaces\RuleInterface;

class UniqueRule implements RuleInterface
{

    protected $atribute;
    public function __construct(string $atribute = null) 
    {
        $this->atribute = $atribute;        
    }
    public function passes(mixed $value, Model $model = null): bool 
    { 
        if($model !== null)
        {            
            return !$model->exists($this->atribute, $value);
        }
        return false;
    }

    public function message(string $atribute, array &$messages = []): array 
    { 
        $messages[$atribute] = "El campo ya existe";
        return $messages;
    }
    
}