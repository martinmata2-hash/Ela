<?php
namespace Marve\Factory\Console;

use DirectoryIterator;

class ConsoleApp
{
	private array $commands = [];
	private array $args = [];
	private string $commandName = '';

	public function __construct(private string $namespace, private array $argv) {}

	public function run(): int
	{
		$this->registerCommands();
		$this->parseOptions();

		$command = $this->commands[$this->commandName];
		$commandInstance = new $command;

		if (!($commandInstance instanceof ConsoleInterface)) 
        {
			throw new ConsoleExcepcion('Command is not implementing the correct interface.');
		}    
		if (!array_key_exists($this->commandName, $this->commands)) 
        {            
			return 0;
		}

        
		$status = $commandInstance->execute($this->args);
		return $status;
	}

	private function registerCommands(): void
	{
		$commandFiles = new DirectoryIterator(__DIR__ . '/Commands');

		foreach ($commandFiles as $commandFile) 
        {
			if (!$commandFile->isFile()) 
            {
				continue;
			}

			$command = $this->namespace . pathinfo($commandFile, PATHINFO_FILENAME);
			$this->commandName = $command::getName();

			$this->commands[$this->commandName] = $command;
		}
	}

	private function parseOptions(): void
	{
		if (!isset($this->argv[1])) 
        {
			echo "Lista de comandos ejecutable ".PHP_EOL.PHP_EOL;
			foreach ($this->commands as $key => $value) 
			{
				echo $key.PHP_EOL;
			}
			//print_r($this->commands);//echo "" $class->intructions();
			exit();
		}

		$this->commandName = $this->argv[1];

		$this->args = array_slice($this->argv, 2);		
	}
}