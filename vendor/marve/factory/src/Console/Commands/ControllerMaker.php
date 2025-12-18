<?php
namespace Marve\Factory\Console\Commands;

use Marve\Factory\Console\ConsoleInterface;

class ControllerMaker implements ConsoleInterface
{       
    private $argv;
    private $datamembers;
    private $table;

    private $className;
    private $temp;

    public function execute(array $argv = []): int 
    {         
        if(count($argv) < 3)
        {
            echo $this->intructions();
            return 0;
        }        
        $this->argv["Controller"] = $argv[0];
        $this->argv["Modelo"] = $argv[1];   
        $this->argv["id"] = $argv[2];    
        $rootfolder = "../../..";
        $directoryName = "$rootfolder/App/Controllers/";
        //Check if the directory already exists.
        if(!is_dir($directoryName))
        {
            //Directory does not exist, so lets create it.
            mkdir($directoryName, 0755, true);
        }        
        return $this->controller($rootfolder);               
    }    

    public static function getName(): string 
    { 
        return "Factory:Controller";
    }

    public function intructions(): int 
    { 
        echo "console Factory:Controller Modelo Tabla id".PHP_EOL;        
        echo "---------------------------------".PHP_EOL;  
        echo " Controller : Nombre del Controllador".PHP_EOL;
        echo " Modelo : Nombre de la clase principal".PHP_EOL;        
        echo " id : Id de la Tabla".PHP_EOL;        
        echo "---------------------------------".PHP_EOL;
        return 0;
    }

    private function controller($folder)
    {

        echo "Creando clases en folder App/Controllers/".$this->argv["Controller"].".php \n";
        $class = file_get_contents("src/Console/Format/Controller.php");    
        $buscar = array("<modelo>", "<controller>", "<key>");
        $reemplazar = array($this->argv["Modelo"],$this->argv["Controller"], $this->argv["id"]);
        $class = str_replace($buscar, $reemplazar,$class);
        $filename = "$folder/App/Controllers/".$this->argv["Controller"].".php";
        return file_put_contents($filename, $class);
        
    }
    
}

