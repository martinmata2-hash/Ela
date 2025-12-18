<?php
namespace Marve\Factory\Console\Commands;
use DirectoryIterator;
use Marve\Factory\Console\ConsoleInterface;

class ModuloMaker implements ConsoleInterface
{       
    private $argv;
    private $datamembers;
    private $table;

    private $className;
    private $temp;

    public function execute(array $argv = []): int 
    {   
        $root = "../../..";      
        if(count($argv) < 1)
        {
            echo $this->intructions();
            return 0;
        }        
        $this->argv["Modulos"] = $argv[0];
        
        
        $commandFiles = new DirectoryIterator(__DIR__ . '/../Modules/'.$this->argv["Modulos"]); 
        foreach ($commandFiles as $commandFile) 
        {
			if (!$commandFile->isFile()) 
            {
				continue;
			}
            $archivo = str_replace("_","/",$commandFile->getFilename());
            $class = file_get_contents(__DIR__."/../Modules/".$this->argv["Modulos"]."/".$commandFile->getFilename());   
            $this->safe_file_put_contents("$root/$archivo", $class);
        }
        
        return 1;        
    }    

    public static function getName(): string 
    { 
        return "Factory:Modulos";
    }

    public function intructions(): int 
    { 
        echo "console Factory:Modulos Modulo".PHP_EOL;        
        echo "Modulos disponibles: Clientes, Productos, Inventarios, Ventas, Admin, LIstas, Reportes, Routes".PHP_EOL;        
        echo "---------------------------------".PHP_EOL;  
        echo " Modulo : El Modulo a instalar".PHP_EOL;        
        echo "---------------------------------".PHP_EOL;
        return 0;
    }
   
    public function safe_file_put_contents($filepath, $data, $flags = 0) 
    {
        $dir = dirname($filepath);
        if (!is_dir($dir)) 
        {
            mkdir($dir, 0777, true); // recursive creation with full permissions
        }
        return file_put_contents($filepath, $data, $flags);
    }
    
}

