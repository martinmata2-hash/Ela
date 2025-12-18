<?php 
namespace App\Models\Pos;

use App\Models\Catalogos\Ajustes;
use App\Models\Catalogos\Clientes;
use App\Models\Core\Generic;
use App\Models\Data\VentasD;
use Marve\Ela\Core\DotEnv;
use stdClass;

class Puntos extends Clientes
{
    function __construct($data_base = "")
    {
        if($data_base == "")
            $data_base = DotEnv::getDB();           
        parent::__construct($data_base);
    }

    public function add(stdClass $data)
    {        
        $cliente = $this->get($data->FacReceptor,"CliID");     

        $porcentaje = (new Ajustes($this->data_base))->get("CliPorcentaje","AjuNombre");
        $porcentaje = $porcentaje->AjuValor??0.00;
        $puntos = $porcentaje * $data->FacTotal;
        $puntaje = new stdClass();
        $puntaje->CliPuntos = $puntos + $cliente->CliPuntos;
        $puntaje->updated = 1;
        if($this->edit($puntaje,$data->FacReceptor,"CliID") <= 0)
            return 0;
        return 1;             
    }

    public function payment(int $puntos, $CliID)
    {
        $cliente = $this->get($CliID,"CliID");
        $puntaje = new stdClass();
        $puntaje->CliPuntos = $puntos - $cliente->CliPuntos;
        $puntaje->updated = 1;
        if($this->edit($puntaje,$CliID,"CliID") <= 0)
            return 0;
        return 1;             
    }
}
