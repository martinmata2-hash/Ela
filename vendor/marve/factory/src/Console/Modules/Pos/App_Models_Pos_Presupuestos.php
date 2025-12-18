<?php
namespace App\Models\Pos;

use App\Models\Data\PresupuestosD;
use Marve\Ela\Core\CurrentUser;
use Marve\Ela\Core\DotEnv;
use Marve\Ela\Core\Model;
use stdClass;

class Presupuestos extends Model
{
   
         
    /**
     *
     * @var PresupuestosD
     */
    public $data;

    /**
     * 
     * @var PrDetalles
     */
    public $Detalles;
    public function __construct( $data_base = "")
    {
        if($data_base == "")
            $data_base = DotEnv::getDB();      
        $this->data_base = $data_base;
        $this->mensaje = array();        
        parent::__construct($data_base, "presupuestos");
        
        $this->Detalles = new PrDetalles($data_base);
        //Inicar tabla
        $this->createTable(new PresupuestosD());
        $this->updateTable();

        //TODO define the rules for adding and editing
        $this->addRules = 
        [           
            "FacReceptor"=>"required|min:1",
        ];
        $this->editRules = 
        [            
            "FacReceptor"=>"required|min:1",
        ];
    }

    public function get(string $id, string $column="", string $condition = "0", string $orderby = "0" )
    {
        if($id == "0")
        {
            $respuestas = $this->query("*", $this->table,$condition, $orderby);
            if(count($respuestas)>0)
            {
                foreach ($respuestas as $key => $value) 
                {    
                    #TODO            
                    #Ajustar si se necesita
                    $respuestas[$key]->Detalles = $this->Detalles->get("0","","DdeDocumento = $id");
                }
                return $respuestas;
            }
            else
                return 0;
        }
        else 
        {
            $respuesta = parent::get($id, $column);
            if($respuesta !== 0)
            {
                #TODO
                #corregir
                $respuesta->Detalles = $this->Detalles->get(0,"","DdeDocumento = $id");
                return $respuesta;
            }
            else return 0;
        }
    }
    
    public function store($data)
    {
        $data->FacUsuario = CurrentUser::getId();
        $data->FacFecha = date("Y-m-d H:i:s");
        $detalles = array();
        if(CurrentUser::isUser())
        {
            if(isset($data->Detalles))
            {
                $detalles = $data->Detalles;
                unset($data->Detalles);
            }
            $this->data = new PresupuestosD($data);
            if($this->isValid() === true)
            {               
                //inicia trasaccion
                $this->conection->begin_transaction();      
                $recibio = $data->FacRecibio + $data->FacRecibio2 + $data->FacRecibio3;
                if($data->FacTotal < $recibio)
                {                    
                    $data->FacNota = $data->FacNota ." | Total:$ $data->FacTotal "."Pago con $ $recibio";
                    $data->FacParidad = $recibio;
                    $recibio = $data->FacTotal;       
                    if($data->FacRecibio > $data->FacTotal)
                        $data->FacRecibio = $data->FacTotal;             
                }
                else
                    $data->FacParidad = $recibio;            
                $id = parent::store($data);
                if($id > 0)
                {                    
                    foreach ($detalles as $detalle) 
                    {                        
                        #TODO
                        #Asignar el id al campo relacionado
                        $detalle->DdeDocumento = $id;                        
                        if($this->Detalles->store($detalle) == 0)
                        {                            
                            $this->conection->rollback();
                            return 0;
                        }                        
                    }
                    $this->conection->commit();
                    return $id;
                }
                else
                {
                    $this->conection->rollback();
                    return 0;
                }
            }
            else return 0;
        }
        else return 0;
    }      
    
    public function edit(stdClass $data, string $id, string $column="", int $user = 0)
    {
        unset($data->FacFecha);
        $data->FacUsuario = CurrentUser::getId();
        $detalles = array();
        if(CurrentUser::isUser())
        {
            $detalles = $data->Detalles;
            unset($data->Detalles);
            $this->data = new PresupuestosD($data);
            if($this->isValid(false) === true)
            {
                $this->conection->begin_transaction();
                $this->Detalles->conection = $this->conection;

                $devolucion = $this->get($id,"FacID",);
                $cambio = $devolucion->FacTotal - $data->FacTotal;
                $data->FacNota .= "| en devolucion se le regreso $ $cambio";
                $id = parent::edit($data, $id, $column, $user);
                if($id > 0)
                {
                    // borrar detalles 
                    $this->Detalles->remove($data->FacID,"DdeDocumento");
                    /** end */
                    //Agregar detalles nuevos    
                    foreach ($detalles as $detalle)
                    {                    
                        $detalle->DdeDocumento = $id;
                        if($this->Detalles->store($detalle) == 0)
                        {
                            $this->conection->rollback();
                            return 0;
                        }
                    }
                    $this->conection->commit();
                    return $id;
                }
                else
                {
                    $this->conection->rollback();
                    return 0;
                }
            }
            else return 0;
        }
        else return 0;
    }   
        
}

