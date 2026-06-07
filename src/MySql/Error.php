<?php
namespace Marve\Ela\MySql;

use Marve\Ela\Core\DotEnv;

class Error extends ConectionIndependent
{
    /**
     * 
     * @param string $data_base
     */
    public function __construct(string $data_base = "")
    {
        if($data_base == "")
            $data_base = DotEnv::getDB();
        parent::__construct($data_base);               
        if($this->isConected($data_base))
        {
            if($resultado = $this->conection->query("SHOW TABLES LIKE 'errores'"))
            {
                if($resultado->num_rows == 0)
                {
                    $this->conection->query($this->table());
                }
            }
        }
    }
    
   
    /**
     * 
     * @param string $donde
     * @param string $que
     * @param string $usuario
     */
    public function report(string $donde, string $que, string $usuario = "0"):void
    {
        if($this->isConected())
        {
            $query = "INSERT INTO errores VALUES(
			NULL,
			'" . $this->conection->real_escape_string($usuario) . "',
			'" . date("Y-m-d H:i:s") . "',
			'" . $this->conection->real_escape_string($donde) . "',
			'" . $this->conection->real_escape_string($que) . "')";
            $this->conection->query($query);
        }        
    }
    
    /**
     * Genera tabla para archivar errores
     * @return string
     */
    private function table():string
    {
        $mysql = "
            
			CREATE TABLE IF NOT EXISTS `errores` (
			  `ErrID` int(11) NOT NULL AUTO_INCREMENT,
			  `ErrUsuario` varchar(20) NOT NULL,
			  `ErrHora` datetime NOT NULL,
			  `ErrDonde` varchar(100) NOT NULL,
			  `ErrQue` text NOT NULL,
			  PRIMARY KEY (`ErrID`)
			) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
        return $mysql;
    }
}
