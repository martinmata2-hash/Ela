<?php
namespace Marve\Ela\Validation;
use Marve\Ela\Core\Model;
use Marve\Ela\Validation\MaxRule;
use Marve\Ela\Validation\MinRule;
use Marve\Ela\Validation\NumberRule;
use Marve\Ela\Validation\RequiredRule;
use Marve\Ela\Validation\UniqueRule;
use stdClass;

class Validator
{
    protected static $ruleMap = 
    [
        "required" => RequiredRule::class,
        "numeric" => NumberRule::class,
        "min" =>MinRule::class,
        "max" => MaxRule::class,
        "unique" => UniqueRule::class,
        "alphanumeric" =>AlphanumericRule::class,
        "string"=>StringRule::class,
        "email"=>EmailRule::class
    ];

    public static function validate(stdClass $data, array $rules = [], Model $model = null)
    {
        $errors = [];
        foreach ($rules as $field => $ruleSet) 
        {
            $rulesArray = explode("|", $ruleSet);
            foreach($rulesArray as $rule)
            {
                $parts = explode(":", $rule, 2);
                $ruleName = $parts[0];
                $parameter = $parts[1]?? null;
                if(isset(self::$ruleMap[$ruleName]))
                {                    
                        $ruleInstance = ($parameter !== null)
                            ? new self::$ruleMap[$ruleName]($parameter)
                            : new self::$ruleMap[$ruleName];                    
                    $value = $data->$field ?? null;
                    if(!$ruleInstance->passes($value,$model))
                    {
                        $ruleInstance->message($field,$errors);
                    }                    
                }
            }
        }
        if(!empty($errors))
        {            
            return $errors;
        }
        return true;

    }
}