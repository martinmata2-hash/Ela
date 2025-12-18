<?php
namespace Marve\Factory\Console\Commands;
use DirectoryIterator;
use Marve\Factory\Console\ConsoleInterface;

class Migration implements ConsoleInterface
{       
    private $argv;
    private $datamembers;
    private $table;

    private $className;
    private $temp;

    public function execute(array $argv = []): int 
    {         
        if(count($argv) < 1)
        {
            echo $this->intructions();
            return 0;
        }        
        $this->argv["All"] = $argv[0];
            
        $root = "../../..";
        $folders = "$root/App/Models/Data/";

        
        
        $commandFiles = new DirectoryIterator($folders);
		foreach ($commandFiles as $commandFile) 
        {
			if (!$commandFile->isFile()) 
            {
				continue;
			}
            $class = str_replace("D.php","",$commandFile->getFilename());
            $table = strtolower($class);
            exec("php console Factory:Data $class $table");            
        }
        return 1;        
    }    

    public static function getName(): string 
    { 
        return "Factory:Migration";
    }

    public function intructions(): int 
    { 
        echo "console Factory:Migration All".PHP_EOL;        
        echo "---------------------------------".PHP_EOL;  
        echo " All : Es requerido".PHP_EOL;        
        echo "---------------------------------".PHP_EOL;
        return 0;
    }
   
    
}

