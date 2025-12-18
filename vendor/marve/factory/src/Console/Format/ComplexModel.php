<?php
namespace App\Models;

use App\Models\Data\<classD>;
use App\Models\<Modelo>;
use Marve\Ela\Core\CurrentUser;
use Marve\Ela\Core\DotEnv;
use Marve\Ela\Core\Model;
use Marve\Ela\Validation\Validator;

class <class> extends Model
{
   
         
    /**
     *
     * @var <classD>
     */
    public $data;

    /**
     * 
     * @var <Modelo>
     */
    public $Detalles;
    public function __construct( $data_base = "")
    {
        if($data_base == "")
            $data_base = DotEnv::getDB();      
        $this->data_base = $data_base;
        $this->mensaje = array();        
        parent::__construct($data_base, "<table>");
        
        $this->Detalles = new <Modelo>($data_base);
        //Inicar tabla
        $this->createTable(new <classD>());
        $this->updateTable();

        //TODO define the rules for adding and editing
        $this->addRules = 
        [
            //"AjuNombre"=>"required|unique:AjuNombre",
            //"AjuValor"=>"required|min:0",            
        ];
        $this->editRules = 
        [
            //"AjuNombre"=>"required|",
            //"AjuValor"=>"required|min:0",            
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
                    $respuestas[$key]->Detalles = $this->Detalles->get("0","","<ModeloRelacion> = $value-><tableid>");
                }
                return $respuestas;
            }
            else
                return 0;
        }
        else 
        {
            $respuesta = $this->query("*", $this->table, "$column = '$id'");
            if(count($respuesta) > 0)
            {
                #TODO
                #corregir
                $respuesta[0]->Detalles = $this->Detalles->get($id,"<ModeloRelacion>");
                return $respuesta[0];
            }
            else return 0;
        }
    }
    
    public function store($data)
    {
        $detalles = array();
        if(CurrentUser::isUser())
        {
            if(isset($data->Detalles))
            {
                $detalles = $data->Detalles;
                unset($data->Detalles);
            }
            $this->data = new <classD>($data);
            if($this->isValid() === true)
            {               
                //inicia trasaccion
                $this->conection->begin_transaction();
                $this->Detalles->conection = $this->conection;
                $id = parent::store($data);
                if($id > 0)
                {
                    foreach ($detalles as $detalle) 
                    {                        
                        #TODO
                        #Asignar el id al campo relacionado
                        $detalle-><ModeloRelacion> = $id;                        
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
        $detalles = array();
        if(CurrentUser::isUser())
        {
            $detalles = $data->Detalles;
            unset($data->Detalles);
            $this->data = new <classD>($data);
            if($this->isValid(false) === true)
            {
                $this->conection->begin_transaction();
                $this->Detalles->conection = $this->conection;
                $id = parent::edit($data, $id, $column, $user);
                if($id > 0)
                {
                    // borrar detalles 
                    $this->Detalles->remove($data-><tableid>,"<ModeloRelacion>");
                    /** end */
                    //Agregar detalles nuevos    
                    foreach ($detalles as $detalle)
                    {                    
                        $detalle-><ModeloRelacion> = $id;
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

