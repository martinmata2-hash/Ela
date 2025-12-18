<?php
namespace Marve\Factory\Console\Commands;

use Marve\Factory\Console\ConsoleInterface;
use Marve\Factory\Console\DataHelper;

class ModeloMaker implements ConsoleInterface
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
        $this->argv["Modelo"] = $argv[0];
        $this->argv["Tabla"] = $argv[1];
        $this->argv["id"] = $argv[2];
        $this->argv["Controller"] = $argv[3]??"";
        $this->argv["Complex"] = $argv[4]??"";
        $this->argv["Relacion"] = $argv[5]??"";
        $rootfolder = "../../..";
        $directoryName = "$rootfolder/App/Models/Data/";
        //Check if the directory already exists.
        if(!is_dir($directoryName))
        {
            //Directory does not exist, so lets create it.
            mkdir($directoryName, 0755, true);
        }        
        $folder = dirname($this->argv["Modelo"]);
        if($folder != ".")
        {
            if(!is_dir("$rootfolder/App/Models/$folder"))
            {
                mkdir("$rootfolder/App/Models/$folder");
            }
        }
        if($this->verify($this->argv["Tabla"]))
        {
            if($this->data($rootfolder) !== false)
            {
                if($this->argv["Controller"] !== "")
                {
                    if($this->controller($rootfolder) === 0)
                        return 0;
                }
                if($this->argv["Complex"] !== "")
                {
                    return $this->complex($rootfolder);
                }
                else
                    return $this->modelo($rootfolder);
            }
            else return 0;
        }
        else return 0;

        
    }    

    public static function getName(): string 
    { 
        return "Factory:Modelo";
    }

    public function intructions(): int 
    { 
        echo "console Factory:Modelo Modelo Tabla id Complex Relacion".PHP_EOL;
        echo "Si usa Complex, Relacion es obligatorio".PHP_EOL;
        echo "---------------------------------".PHP_EOL;  
        echo " Modelo : Nombre de la clase".PHP_EOL;
        echo " Tabla : Nombre de la tabla".PHP_EOL;
        echo " id : id de la tabla".PHP_EOL;   
        echo " Controller : Nombre del controlador opcional".PHP_EOL;
        echo " Complex : Modelo relacionado opcional".PHP_EOL;
        echo " Relacion : Campo relacionado obligatorio si se usa Complex".PHP_EOL;
        echo "---------------------------------".PHP_EOL;
        return 0;
    }

    private function complex($folder)
    {
        if($this->argv["Relacion"]!== "")
        {
            echo "Creando clases en folder App/Models/".$this->argv["Modelo"].".php ".PHP_EOL;
            $class = file_get_contents("src/Console/Format/ComplexModel.php");   
            $buscar = array("<class>","<classD>","<table>","<tableid>","<Modelo>","<ModeloRelacion>");
            $reemplazar = array($this->className, $this->className."D", $this->argv["Tabla"],
                    $this->argv["id"], $this->argv["Complex"], $this->argv["Relacion"] );
            $class = str_replace($buscar, $reemplazar,$class);
            $filename = "$folder/App/Models/".$this->argv["Modelo"].".php";
            return file_put_contents($filename, $class);            
        }
        else
            return $this->intructions();
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
    private function modelo($folder)
    {
        echo "Creando clases en folder App/Models/".$this->argv["Modelo"].".php \n";
        
        $class = file_get_contents("src/Console/Format/Model.php");   
        $buscar = array("<class>","<classD>","<table>","<tableid>");
        $reemplazar = array($this->className, $this->className."D", $this->argv["Tabla"],
                $this->argv["id"]);
        $class = str_replace($buscar, $reemplazar,$class);
        $filename = "$folder/App/Models/".$this->argv["Modelo"].".php";
        return file_put_contents($filename, $class);            
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

