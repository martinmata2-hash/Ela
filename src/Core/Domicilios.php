<?php
/**
 * @version v2020_2
 * @author Martin Mata
 */
namespace  Marve\Ela\Core;

use Marve\Ela\MySql\Query;

class Domicilios extends Query
{
    public $message;
    private $result = array();
    function __construct($data_base = "")
    {
       if($data_base == "")
            $data_base = DotEnv::getDB();
        parent::__construct($data_base);    
    }
    /**
     *
     * @param string $cp
     *
     */
    public function cp($cp, $pais = "MEX")
    {
        $codigos = $this->query("*", "codigos inner join estados on CodEstado = EstCodigo AND EstPais = '$pais'", "CodCodigo = '$cp'");
        if (count($codigos) > 0)
        {
            return $codigos[0];
        }
        else
            return 0;
    }
    /**
     *
     * @return string
     */
    public function paises()
    {
        return $this->options("PaiCodigo as id, PaiNombre as name", "paises", "id", "MEX");        
    }
    /**
     *
     * @param string $pais
     *
     * @return string
     */
    public function estados($pais)
    {
        return $this->options("EstCodigo as id, EstNombre as name", "estados", "id", "0", "EstPais = '$pais'");        
    }
    /**
     *
     * @param string $estado
     * @param string $municipio
     *
     * @return string
     */
    public function municipios($estado, $municipio = 0)
    {
        return $this->options("MunCodigo as id, MunNombre as name", "municipios", "id", "$municipio", "MunEstado = '$estado'");        
    }
    /**
     *
     * @param string $estado
     * @param string $municipio
     *
     * @return string
     */
    public function colonia($estado, $municipio, $pais = "MEX")
    {
        if($pais == "MEX")
            $paises = " AND ColID < 145405 ";
        elseif ($pais == "USA")
            $paises = " AND ColID > 145404 ";

        return $this->options("distinct ColCodigo as id, ColNombre as name",
            "colonias inner join codigos on ColCp = CodCodigo inner join municipios on MunCodigo = CodMunicipio",
            //"municipios inner join codigos on MunCodigo = CodMunicipio left join colonias on ColCp = CodCodigo", 
            "id", "0", "CodEstado = '$estado' AND MunCodigo = '$municipio' AND MunEstado = '$estado' $paises");
    }
    /**
     * regresa las colonias con el mismo codigo
     *
     * @param string $cp
     *
     * @return string
     */
    public function localidad($cp)
    {
        return $this->options("ColCp,ColCodigo as id, ColNombre as name", "colonias", "id", $cp, "ColCp like '$cp%'");
    }
    /**
     *
     * @param string $codigo
     *            codigo de la colonia
     * @param string $nombre
     *            nombre de la colonia
     *            
     */
    public function coloniaCp($codigo, $nombre)
    {
        $resultado = $this->query("ColCp", "colonias", "ColCodigo = '$codigo' AND ColNombre = '$nombre'");
        if (count($resultado) > 0)
        {            
            return $resultado[0]->ColCp;
        }
        else
            return 0;
    }
}