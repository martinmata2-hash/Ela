<?php
namespace App\Models\Inventarios;

use App\Models\Catalogos\Inventarios;
use App\Models\Data\MoDetallesD;
use Marve\Ela\Core\CurrentUser;
use Marve\Ela\Core\Model;
use Marve\Ela\Core\DotEnv;
use stdClass;

class MoDetalles extends Model
{
   
         
    /**
     *
     * @var MoDetallesD
     */
    public $data;

    public function __construct( $data_base = "")
    {
        if($data_base == "")
            $data_base = DotEnv::getDB();           
        $this->data_base = $data_base;
        $this->message = array();        
        parent::__construct($data_base, "salidadetalles");
        
        //Inicar tabla
        $this->createTable(new MoDetallesD());
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
    
     public function remove(string $id, string $column, int $user = 0)
    {
        if(CurrentUser::isUser())
        {
            $Detalles = $this->get("0","","DdeDocumento = $id");
            if(parent::remove($id,$column,$user) > 0)
            {
                $INVENTARIO = new Inventarios($this->data_base);
                foreach ($Detalles as $key => $data) 
                {                                        
                    $INVENTARIO->input($data->DdeProducto, $data->DdeCantidad);
                }
                return 1;
            }
            else return 0;
        }           
        else return 0;   
    }

    public function store(stdClass $data)
    {
        if(CurrentUser::isUser())
        {
            $this->data = new MoDetallesD($data);
            if($this->isValid() === true)
            {               
                 if(parent::store($data) > 0)
                 {
                    $INVENTARIO = new Inventarios($this->data_base);                    
                    return $INVENTARIO->output($data->DdeProducto, $data->DdeCantidad);
                 }
                 else return 0;
            }
            else return 0;
        }
        else return 0;
    }
    
}

