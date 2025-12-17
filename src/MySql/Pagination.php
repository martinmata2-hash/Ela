<?php
/**
 * Clase que ayuda con la paginacion
 */
namespace Marve\Ela\MySql;

use Marve\Ela\Core\DotEnv;
use Marve\Ela\Core\Session;
use Marve\Ela\Html\Table\Table;
use stdClass;

/**
 * $OBjeto->Pagination(14, true)  //Numero de records por pagina, bool render en table o en array
 * ->Query("CliNombre as nombre, CliDireccion as domiclio")
 * ->Table("clientes inner join ventas")
 * ->Show(1); //Mostrar numero de pagin
 * @package Marve\Ela\MySql
 */
class Pagination extends QueryHelper
{    
    /**
     * Total de records en resultado
     * @var mixed
     */
    protected $total;
    /**
     * Numero de Paginas en resultado
     * @var int
     */
    protected $totalPages;

    /**
     * Numero de records pro pagina
     * @var int
     */
    protected $pageRecords;
    /**
     * Numero de Pagina actual
     * @var int
     */
    protected $pageNumber;
    
    /**
     * Define si el resultado se regresa en formato table
     * @var bool
     */
    protected $showTable;
    

    protected $title;

    protected $currentPage;

    protected $mensaje;
    public function __construct(string $table = "",string $data_base = "")
    {
        if($data_base == "")
            $data_base = DotEnv::getDB();
        parent::__construct($table,$data_base);        
                
        $this->pageRecords = 14;
        $this->showTable = false;        
        $this->currentPage= "page";
    }

    /**
     * Inicializa los valores para la paginacion
     * @param int $pageRecords 
     * @param bool $showTable 
     * @return $this 
     */
    public function Pagination($pageRecords = 14, $showTable = false)
    {
        $this->pageRecords = $pageRecords;
        $this->showTable = $showTable;
        return $this;
    }
    
    /**
     * Elimina datos guardados en Session
     * @return void 
     */
    public function RemoveCache()
    {
        Session::remove($this->currentPage);
        Session::remove($this->currentPage."_data");
    }

    public function Title($title)
    {
        $this->title = $title;
        return $this;
    }

    public function Page($currentPage= "page")
    {
        $this->currentPage= $currentPage;
        return $this;
    }
    /**
     * Restaura los datos desde Session
     * @return bool 
     */
    private function GetCache()
    {        
        if(Session::get($this->currentPage))
        {
            if(Session::get($this->currentPage) == $_SERVER["REDIRECT_URL"])
            {
                $data = Session::get($this->currentPage."_data");
                $this->total = $data["total"];
                $this->columns = $data["columns"];
                $this->table = $data["table"];
                $this->condition = $data["condition"]; 
                $this->order = $data["order"]; 
                $this->group = $data["group"]; 
                $this->limit = $data["limit"];
                return true;
            }
            else
                return false;
        }
        else return false;
    }

    /**
     * Archiva los datos en Session
     * @return void 
     */
    private function SetCache()
    {
        
        @Session::set($this->currentPage, $_SERVER["REDIRECT_URL"]);
        $data["total"] = $this->total;
        $data["columns"] = $this->columns; 
        $data["table"] = $this->table;
        $data["condition"] = $this->condition;
        $data["order"] = $this->order;
        $data["group"] = $this->group;
        $data["limit"] = $this->limit;
        Session::set($this->currentPage."_data", $data);                    
    }

    /**
     * Mostrar el paginado numero x a pantalla o regresa datos en array
     * @param int $pageNumber 
     * @return string|array 
     */
    public function Show(int $pageNumber = 1, $grid = false)
    {        
        //if(!$this->GetCache())
        //{
            $this->Count();
        //}
        $plus = $this->total % $this->pageRecords;
        if($plus != 0)
            $plus = 1;        
        $this->totalPages = intval(($this->total/$this->pageRecords)) + $plus;               
        $inicio = ($pageNumber - 1) * $this->pageRecords; 
        if($inicio <= 0 )
            $inicio = "";
        else $inicio = $inicio." ,";
        $this->limit = "$inicio $this->pageRecords";        
        if($this->showTable)
        {            
            $TABLE = new Table();       
            $data = parent::Render();
            if(count($data) > 0)
            {                       
                $TABLE->inicio($this->table,"",($this->title)??$this->table, "table-striped", $grid)
                ->header()->htr();                               
                foreach ($data as $key => $value) 
                {                 
                    foreach ($value as $k => $v) 
                    {
                        $TABLE->th("",$k??"");
                    }     
                    break;               
                }
                $TABLE->body();
                foreach ($data as $key => $value) 
                {
                    $TABLE->tr();
                    foreach ($value as $k => $v) 
                    {
                        $TABLE->td($v??"");
                    }                                        
                }
            }
            return $TABLE->render().$this->Boostrap($pageNumber);
        }
        else
        {
            $respuesta["data"] = $this->Render();
            $respuesta["totalRecords"] = $this->total;
            $respuesta["pageNumber"] = $pageNumber;
            $respuesta["totalPages"] = $this->totalPages; 
            $respuesta["pagination"] = $this->Boostrap($pageNumber);
        }
        return $respuesta;
    }

    /**
     * Obtiene el numero de datos en query 
     * @return void 
     */
    private function Count()
    {
        $request  = $this->query("COUNT(*) as total",$this->table, $this->condition, $this->order, $this->group, $this->limit);
        if(count($request) > 0)
            $this->total = $request[0]->total;
        else $this->total = 0;
        $this->SetCache();        
    }

    /**
     * Regresa links de paginacion con css boostrap
     * @param int $paginaNumero 
     * @return string 
     */
    private function Boostrap($pageNumber)
    {                
        $next = ($this->totalPages == $pageNumber)?$pageNumber:$pageNumber + 1;        
        $previous = ($pageNumber == 1)?$pageNumber:$pageNumber - 1;
        $html = "
        <nav aria-label='Page navigation'>        
            <ul class='pagination justify-content-center'>
                <li class='page-item'>
                    <a class='page-link' href='#'>
                        <span aria-hidden='true'>Total $this->total </span>
                    </a>
                </li>
                <li class='page-item'>
                    <a class='page-link' href='?$this->currentPage=$previous' aria-label='Previous'>
                        <span aria-hidden='true'>&laquo;</span>
                        <span class='sr-only'>Previous</span>
                    </a>
                </li>";
            $count = 0;
            if($pageNumber - 3 > 0)
                $inicio = $pageNumber - 3;
            else $inicio = 1;
            for ($i=$inicio; $i <= $this->totalPages; $i++) 
            {                 
                $count++;
                if($pageNumber == $i)
                {
                    $html .= "
                    <li class='page-item active'>
                        <span class='page-link'>$i
                            <span class='sr-only'>(current)</span>
                        </span>
                    </li>";
                }
                else
                    $html .= "<li class='page-item'><a class='page-link' href='?$this->currentPage=$i'>$i</a></li>";
                if($count == 7)
                    break;
            }
        $html .= "
                <li class='page-item'>
                    <a class='page-link' href='?$this->currentPage=$next' aria-label='Next'>
                        <span aria-hidden='true'>&raquo;</span>
                        <span class='sr-only'>Next</span>
                    </a>
                </li>
            </ul>
      </nav>";
      return $html;
    }
}