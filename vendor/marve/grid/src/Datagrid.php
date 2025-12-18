<?php
/**
 * @version v2020_1
 * @author Martin Mata
 */
namespace Marve\Ela\Grid;
use Marve\Ela\Core\DotEnv;

require_once 'jqgrid.php';
require_once 'htmlpurifier/HTMLPurifier.standalone.php';
class Datagrid
{
	public $g;
	/**
	 * 
	 * @var array
	 */
	public $cols;
	function inicio($base_datos = "")
	{
		if($base_datos == "")
            $base_datos = DotEnv::getDB();
							
			$db_conf = array();
			$db_conf["type"] = "mysqli";
			$db_conf["server"] = DotEnv::getHost();
			$db_conf["user"] = DotEnv::getUser();
			$db_conf["password"] = DotEnv::getPassword();
			$db_conf["database"] = $base_datos;
			$this->g = new \jqgrid($db_conf);
		
	}

	function campos($tables)
	{
		$this->cols = array();
		foreach ($tables as $campos)
		{
			$col = array();
			foreach ($campos as $key => $value)
			{
				$col[$key]=$value;
			}
			$this->cols[] = $col;
		}
		$col = array();
		$col["title"] = "Action";
		$col["name"] = "act";
		$col["width"] = "50";
		$col["hidden"] = true;
		$col["export"] = false;
		$this->cols[] = $col;

	}

	/**
	 *
	 * @param string $titulo encabezado
	 * @param string $id campo a sortear
	 * @param array $buttons add,edit,delete,rowactions,excel,multiselect,footerrow
	 */
	public function encabezado($titulo,$id,$buttons,$order="desc",$height = "380", $width="900")
	{
		
		if(!isset($buttons[5]))
			$buttons[5] = false;
		if(!isset($buttons[6]))
			$buttons[6] = false;
		$grid["rowNum"] = 15; // by default 20
		$grid["sortname"] = $id;//'CliID'; // by default sort grid by this field
		$grid["sortorder"] = $order; // ASC or DESC
		$grid["caption"] = "<h6 style='text-transform: uppercase;'><center>$titulo</center></h6>"; // caption of grid	
		$grid["shrink_to_fit"] = false;		
		//$grid["autoresize"] = true; // expand grid to screen width
		$grid["autowidth"] = true; // expand grid to screen width
		$grid["autofilter"] = false;
		//$grid["width"] = $width; // defaults to 900
		$grid["height"] = $height;//"400";
		$grid["multiselect"] = $buttons[5]; // allow you to multi-select through checkboxes
		$grid["multiselectWidth"] = "5";
        $grid["footerrow"] = $buttons[6]; // allow you to multi-select through checkboxes        
		$grid["export"] = array("filename"=>$titulo, "heading"=>$titulo, "orientation"=>"landscape", "paper"=>"a4");
		// 	for excel, sheet header
		$grid["export"]["sheetname"] = "Detalles";
		// export filtered data or all data
		$grid["export"]["range"] = "filtered"; // or "all"


		$this->g->set_options($grid);

		$this->g->set_actions(array(
				"add"=>$buttons[0], // allow/disallow add
				"edit"=>$buttons[1], // allow/disallow edit
				"delete"=>$buttons[2], // allow/disallow delete
				"rowactions"=>$buttons[3],//true, // show/hide row wise edit/del/save option
				"search" => "simple", // show single/multi field search condition (e.g. simple or advance)
		        "showhidecolumns"=>true,
				"export_excel"=>$buttons[4],
				"export_pdf"=>$buttons[4]				
			));
		
		$a["scroll"]=true;
		$this->g->set_options($a);

	}

	function sql($query,$tabla,$where = "0", $group = "0")
	{
		$this->g->select_command = $query;
		if($where != "0")
			$this->g->select_command .= " Where ($where)";
		if($group != "0")
			$this->g->select_command .= " Group by $group";
		// this db table will be used for add,edit,delete
		$this->g->table = $tabla;

		// pass the cooked columns to grid
		$this->g->set_columns($this->cols);
	}

	/**
	 * Muestra el grid a pantalla, 
	 * @param number $list
	 * @return void|string
	 */
	function mostrar($list = 1)
	{
		// generate grid output, with unique grid name as 'list1'
		if($list == 1)
			$out = $this->g->render("list1");
		else $out = $this->g->render("list".$list);
		return $out;
	}
	
	/**
	 * ajustar el grid a tamaño de pantalla (true) dejar las medidas asignadas sin justar (false)
	 * @param bool $auto
	 */
	function screen($auto)
	{
		$grid["autowidth"] = $auto;
		$this->g->set_options($grid);
	}
}