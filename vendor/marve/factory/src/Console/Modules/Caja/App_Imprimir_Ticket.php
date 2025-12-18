<?php
namespace App\Imprimir;

use App\Models\Catalogos\Ajustes;
use Marve\Ela\Print\Articulo;

class Ticket extends Articulo 
{
    /**
     * 
     * @var Ajustes;
     */
    protected $Ajustes;
    public function __construct($cantidad = "", $texto = "", $precio = "", $unalinea = true)
    {   
        $this->Ajustes = new Ajustes();     
        parent::__construct($cantidad, $texto, $precio, $unalinea, $this->Ajustes->get("FacLetras","AjuNombre")->AjuValor);

    }

    public function encabezado(): string
    {
        $texto = "";
        $encabezado = explode("<br>",$this->Ajustes->get("FacEncabezado", "AjuNombre")->AjuValor);
        foreach ($encabezado as $value) {$texto .= $this->centrado($value);}
        return $texto;            
    }

    public function pie(): string
    {
        $texto = "";
        $pie = explode("<br>",$this->Ajustes->get("FacPie", "AjuNombre")->AjuValor);
        foreach ($pie as $value) {$texto .= $this->centrado($value);};     
        $texto .= $this->espacios();  
        return $texto;
    }

    public function espacios($espacios = 3): string
    {
        $texto = "";
        for ($i=0 ; $i < $espacios ; $i++ ) 
        { 
            $texto .= $this->separador(" ");        
        }
        return $texto;
    }

    public function formapago($formapago)
    {
        switch ($formapago) 
        {
            case '01':
                return "Efectivo";
            case "02":
                return "Cheque";
            case "03":
                return "Trasferencia";
            case "04":
                return "Credito";
            case "28":
                return "Debito";   
            case "99":
                return "Mixto";
            case "100":
                return "Puntos";
            default:
                return "No especificado";                
        }
    }
    
}