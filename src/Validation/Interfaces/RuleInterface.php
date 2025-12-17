<?php 
namespace Marve\Ela\Validation\Interfaces;

use Marve\Ela\Core\Model;

interface RuleInterface
{
    public function passes(mixed $value, Model $model = null):bool;
    public function message(string $atribute, array &$messages = []):array;

}