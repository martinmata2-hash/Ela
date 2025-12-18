<?php
namespace Marve\Factory\Console\Commands;

use Marve\Factory\Console\ConsoleInterface;
use Marve\Factory\Console\DataHelper;

class DataMaker implements ConsoleInterface
{       
    private $argv;
    private $datamembers;
    private $table;

    private $className;
    private $temp;

    public function execute(array $argv = []): int 
    {         
        if(count($argv) < 2)
        {
            echo $this->intructions();
            return 0;
        }        
        $this->argv["Modelo"] = $argv[0];
        $this->argv["Tabla"] = $argv[1];       
        $rootfolder = "../../..";
        $directoryName = "$rootfolder/App/Models/Data/";
        //Check if the directory already exists.
        if(!is_dir($directoryName))
        {
            //Directory does not exist, so lets create it.
            mkdir($directoryName, 0755, true);
        }        
       
        if($this->verify($this->argv["Tabla"]))
        {
            return $this->data($rootfolder);            
        }
        else return 0;
        
    }    

    public static function getName(): string 
    { 
        return "Factory:Data";
    }

    public function intructions(): int 
    { 
        echo "console Factory:Data Modelo Tabla".PHP_EOL;        
        echo "---------------------------------".PHP_EOL;  
        echo " Modelo : Nombre de la clase".PHP_EOL;
        echo " Tabla : Nombre de la tabla".PHP_EOL;        
        echo "---------------------------------".PHP_EOL;
        return 0;
    }

    private function verify($tabla)
    {
        $this->temp = explode("/",$this->argv["Modelo"]);
        $this->className = end($this->temp);

        $HELPER = new DataHelper();
        $this->datamembers = $HELPER->getDataMembers($tabla);
        $this->table = $HELPER->createTable($tabla);        
        return $this->datamembers["public"] !== "";
    }    
    private function data($folder)
    {
        echo "Creando clases en folder App/Models/Data/".$this->argv["Modelo"]."D.php \n";
               
        $classD = file_get_contents("src/Console/Format/Data.php");
        $buscar = array("<classname>","<public>","<datamembers>","<create>");        
        $reemplazar = array($this->className."D", $this->datamembers["public"],$this->datamembers["datamembers"],$this->table[1]);
        $classD = str_replace($buscar,$reemplazar, $classD);
        $filename = "$folder/App/Models/Data/".$this->className."D.php";
        return file_put_contents($filename, $classD);
    }
    
}

