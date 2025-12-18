<?php
namespace App\Models\Catalogos;

use App\Models\Data\ProductosD;
use Marve\Ela\Core\Model;
use Marve\Ela\Core\DotEnv;
use stdClass;

class Productos extends Model
{
   
         
    /**
     *
     * @var ProductosD
     */
    public $data;

    public function __construct( $data_base = "")
    {
        if($data_base == "")
            $data_base = DotEnv::getDB();           
        $this->data_base = $data_base;
        $this->message = array();        
        parent::__construct($data_base, "productos");
        
        //Inicar tabla
        $this->createTable(new ProductosD());
        $this->updateTable();
        //TODO define the rules for adding and editing
        $this->addRules = 
        [
            "ProDescripcion"=>"required|unique:ProDescripcion",
            "ProPrecio"=>"required|min:0",     
            "ProCodigo"=>"required|min:3|unique:ProCodigo",
            "ProCategoria"=>"required|min:1",
            "ProSubCat"=>"required|min:1",
            "ProProveedor"=>"required|min:1",
            "ProMarca"=>"required|min:1"       
        ];
        $this->editRules = 
        [
            "ProDescripcion"=>"required|",
            "ProPrecio"=>"required|min:0",     
            "ProCodigo"=>"required|min:3",
            "ProCategoria"=>"required|min:1",
            "ProSubCat"=>"required|min:1",
            "ProProveedor"=>"required|min:1",
            "ProMarca"=>"required|min:1"              
        ];
    }    

    public function store(stdClass $data)
    {
        $id = parent::store($data);
        if($id > 0)
        {
            $INVENTARIOS = new Inventarios($this->data_base);
            $INVENTARIOS->input($id, 0);
            return $id;
        }
        return 0;
    }
                  
     public function subcat($categoria)
    {
       return $this->options("distinct SubNombre as name, SubID as id","productos inner join subcat on ProSubCat = SubID","id",
      0,"ProCategoria = $categoria","name");
    }
}

