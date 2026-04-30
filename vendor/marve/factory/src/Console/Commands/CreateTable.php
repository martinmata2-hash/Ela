<?php
namespace Marve\Factory\Console\Commands;
use DirectoryIterator;
use Marve\Ela\Core\DotEnv;
use Marve\Ela\MySql\QueryHelper;
use Marve\Factory\Console\ConsoleInterface;
use Marve\Factory\Console\DataHelper;

class CreateTable implements ConsoleInterface
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
        $this->argv["Data"] = $argv[0];
            
        $root = "../../..";
        $folders = "$root/App/Models/Data/";

        $HELPER = new DataHelper();        
        $HELPER->conection->multi_query
        (
            "CREATE TABLE IF NOT EXISTS migrations (
                `MigID` INT NOT NULL AUTO_INCREMENT , 
                `MigTable` VARCHAR(40) NOT NULL , 
                `MigVersion` SMALLINT NOT NULL , 
                `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , 
                PRIMARY KEY (`MigID`)) ENGINE = MyISAM;"
        );
        
        if($this->argv["Data"] == "All")
        {
            $commandFiles = new DirectoryIterator($folders);
            foreach ($commandFiles as $commandFile) 
            {
                if (!$commandFile->isFile()) 
                {
                    continue;
                }
                $class = str_replace(".php","",$commandFile->getFilename());               
                $classname = "App\Models\Data\\".$class;
                $table = strtolower($class);
                $table = substr($table, 0, -1);
                $QUERY = new QueryHelper($table, DotEnv::getDB());
                $versiones = $QUERY->Init("MigID, MigVersion")->Table("migrations")
                    ->Condition("MigTable = '$table'")->Render();
                $version = $versiones[0]->MigVersion ?? 0;
                $version++;
                $id = $versiones[0]->MigID ?? 0;
                $sql = "INSERT INTO migrations (MigID, MigTable, MigVersion) VALUES ($id, '$table', $version) ON DUPLICATE KEY UPDATE MigVersion = $version";
                $HELPER->conection->query($sql);
                $DATA = new $classname();
                $HELPER->createTableFromQuery($DATA->sql());            
            }
        }
        else
        {
            $class = $this->argv["Data"];
            $classname = "App\Models\Data\\".$class;
            $table = strtolower($class);
            $table = substr($table, 0, -1);
            $QUERY = new QueryHelper($table, DotEnv::getDB());
            $versiones = $QUERY->Init("MigID, MigVersion")->Table("migrations")
                ->Condition("MigTable = '$table'")->Render();
            $version = $versiones[0]->MigVersion ?? 0;
            $version++;
            $id = $versiones[0]->MigID ?? 0;
            $sql = "INSERT INTO migrations (MigID, MigTable, MigVersion) VALUES ($id, '$table', $version) ON DUPLICATE KEY UPDATE MigVersion = $version";
            $HELPER->conection->query($sql);
            $DATA = new $classname();
            $HELPER->createTableFromQuery($DATA->sql());            
        }
        return 1;        
    }    

    public static function getName(): string 
    { 
        return "Factory:CreateTable";
    }

    public function intructions(): int 
    { 
        echo "console Factory:CreateTable DataClass".PHP_EOL;        
        echo "---------------------------------".PHP_EOL;  
        echo " All : crear todas las DataClass en Models/Data".PHP_EOL;        
        echo "---------------------------------".PHP_EOL;
        return 0;
    }
   
    
}

