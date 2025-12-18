<?php
namespace Marve\Factory\Console;
interface ConsoleInterface
{
    public function execute(array $argv = []): int;

    public static function getName(): string;

    public function intructions():int;
}