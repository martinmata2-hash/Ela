<?php
namespace Marve\Factory\Console\Commands;

use Marve\Ela\Core\DotEnv;
use Marve\Ela\MySql\QueryHelper;
use Marve\Factory\Console\ConsoleInterface;
use Marve\Factory\Console\DataHelper;
use stdClass;

class MigrationMaker implements ConsoleInterface
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


        $this->argv["Modelo"] = $argv[0];
        $this->argv["Tabla"] = $argv[1];       
        $rootfolder = "../../..";
        $host = DotEnv::getHost();
        $user = DotEnv::getUser();
        $pass = DotEnv::getPassword();
        $database = DotEnv::getDB();
        $table = $this->argv["Tabla"];

        if(class_exists("App\Models\Data\\".$this->argv["Modelo"]."D"))
        {
            $clasname = "App\Models\Data\\".$this->argv["Modelo"]."D";
            $DATA = new $clasname();
            $QUERY = new QueryHelper($table, DotEnv::getDB());
            $versiones = $QUERY->Init("MigID, MigVersion")->Table("migrations")
                ->Condition("MigTable = '$table'")->Render();
            $version = $versiones[0]->MigVersion ?? 0;
            $version++;
            $id = $versiones[0]->MigID ?? 0;
            $sql = "INSERT INTO migrations (MigID, MigTable, MigVersion) VALUES ($id, '$table', $version) ON DUPLICATE KEY UPDATE MigVersion = $version";
            $HELPER->conection->query($sql);

            $filename = $rootfolder."/respaldos/backup_$version"."_$table.sql";  
            $mysqldump = "\"C:\\xampp\\mysql\\bin\\mysqldump.exe\"";
            $command = "{$mysqldump} --host={$host} --user={$user} --password={$pass} --no-create-info --skip-triggers --skip-add-drop-table --skip-add-locks --skip-comments --complete-insert {$database} {$table} > {$filename}"; 
            exec($command, $output, $result); 
            if ($result !== 0) 
            { 
                echo "Error al crear el respaldo de la tabla $table";
                return 0; 
            }
            $HELPER->dropTable($table);
            $HELPER->createTableFromQuery($DATA->sql());
            $mysqldump = "\"C:\\xampp\\mysql\\bin\\mysql.exe\"";
            $command = "{$mysqldump} --host={$host} --user={$user} --password={$pass} {$database} < {$filename}"; 
            exec($command, $output, $result); 
            if ($result !== 0) 
            { 
                echo "Error al restaurar el respaldo de la tabla $table";
                return 0;
            }
            echo "Migracion completa";
            return 1; 
           
        }
        else return 0;
           
        
    }    

    public static function getName(): string 
    { 
        return "Factory:Migration";
    }

    public function intructions(): int 
    { 
        echo "console Factory:Migration Modelo Tabla".PHP_EOL;        
        echo "---------------------------------".PHP_EOL;  
        echo " Modelo : Nombre de la clase".PHP_EOL;
        echo " Tabla : Nombre de la tabla".PHP_EOL;        
        echo "---------------------------------".PHP_EOL;
        return 0;
    }   
}

