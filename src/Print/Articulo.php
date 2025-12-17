<?php
/**
 * @version v2020_2
 * @author Martin Mata
 */

namespace  Marve\Ela\Print;


define("_EOL",PHP_EOL);
class Articulo 
{
	/**	 
	 * @var string
	 */
	private $Cantidad;
	/**
	 * @var string
	 */
	private $Descripcion;
	/**
	 * @var string
	 */
	private $Precio;
	/**
	 * @var int
	 */
	private $primer_espacio = 5;
	/**
	 * @var int
	 */
	private $segundo_espacio = 17;
	/**
	 * @var int
	 */
	private $tercer_espacio = 9;
	/**
	 * @var bool
	 */
	private $una_linea;
	
  
	
	/**
	 * 
	 * @param string $name
	 * @param mixed $value
	 */
	public function __set($name, $value)
	{
		$this->$name = $value;
	}
	
	/**
	 * 
	 * @param string $cantidad
	 * @param string $descripcion
	 * @param string $precio
	 * @param bool $unalinea	 
	 */
	public function __construct($cantidad = "", $descripcion = "", $precio = "", $unalinea = true, $caracteres = 32) 
	{	   
		$this -> Cantidad =$this->unidades($cantidad);
		$this -> Descripcion = $descripcion;
		$this -> Precio = $this->formatnumero($precio);
		$this-> una_linea = $unalinea;
		$this->caracteres($caracteres);
	}
	
	/**
	 * 
	 * @return string
	 */
	public function __toString() 
	{
				
		if($this->una_linea)
		{
			$long = strlen($this->Descripcion);
	
			if($long > $this->segundo_espacio)
			{
				$extra = substr($this->Descripcion,$this->segundo_espacio,$this->segundo_espacio);
				$this->Descripcion = substr($this->Descripcion,0,$this->segundo_espacio);
			} 
			else $extra = "";
			
			$left = str_pad($this -> Cantidad, $this->primer_espacio," ",STR_PAD_RIGHT) ;
			$middle = str_pad($this->Descripcion, $this->segundo_espacio," ",STR_PAD_RIGHT);		
			$right = str_pad($this -> Precio, $this->tercer_espacio, " ", STR_PAD_LEFT);
			if(strlen($extra) > 5)
			{
				$extraLinea = str_pad(' ', $this->primer_espacio,' ',STR_PAD_RIGHT).
							  str_pad($extra, $this->segundo_espacio,' ',STR_PAD_RIGHT).
							  str_pad(" ", $this->tercer_espacio, ' ', STR_PAD_LEFT);
				return "$left$middle$right"._EOL."$extraLinea"._EOL;
			}
			return "$left$middle$right"._EOL;
		}
		else 
		{			
			return str_pad($this->Descripcion,$this->primer_espacio+$this->segundo_espacio+$this->tercer_espacio," ",STR_PAD_BOTH)._EOL;
		}
	}
	
	/**
	 * aigna el numero de caracteres en la impresion 
	 * @param int $chars
	 */
	public function caracteres($chars = 32)
	{
		$this->primer_espacio = \intval($chars * 0.20);
		$this->segundo_espacio = \intval($chars * 0.50);
		$this->tercer_espacio = \intval($chars * 0.30);
		if($chars !== 32)
		{
		    $this->primer_espacio =  intval($chars/6.66);
		    $this->segundo_espacio = intval($chars/1.73);
		    $this->tercer_espacio = intval($chars/4);
		}
	}
	
	/**
	 * 
	 * @param string $linea
	 * @return string
	 */
	public function separador($linea)
	{
		return str_pad($linea, $this->segundo_espacio+$this->tercer_espacio, $linea,STR_PAD_BOTH)._EOL;
	}
	
	/**
	 *
	 * @param string $linea
	 * @return string
	 */
	public function centrado($linea)
	{
	    
		return str_pad($linea,$this->primer_espacio+ $this->segundo_espacio+$this->tercer_espacio," ",STR_PAD_BOTH)._EOL;
	}
	
	/**
	 *
	 * @param string $linea
	 * @param int $medida
	 * @return string
	 */
	public function linea($linea,$medida,$cuantas = 1)
	{
	    $resultado = "";
	    $lineas = str_split($linea, $medida);	
	    $counter = 0;
	    foreach ($lineas as $value) 
	    {
	        if(++$counter <= $cuantas)
	           $resultado .=str_pad($value,$medida," ",STR_PAD_RIGHT)." | ";
	    }
	    if(count($lineas) < $cuantas)
	    {
	        for ($i = count($lineas); $i < $cuantas; $i++)	    
	        {
	            $resultado .=str_pad("...",$medida," ",STR_PAD_BOTH)." | ";
	        }
	    }
	    return $resultado;
	}
	
	protected function unidades($numero)
	{
		if(stripos($numero,".") === false)
			return $numero;
		elseif(\explode(".", $numero)[1] == 0)
			return \explode(".", $numero)[0];
		else return $numero;
			
	}
	/**
	 * Imprimir con apariencia de tabla
	 * @param int $columnas
	 * @param array $datos
	 * @return string
	 */
	public function tabla($columnas, $datos, $chars = 32)
	{	    
	    $caracteres = $chars;
	    $espacio = intval($caracteres/$columnas);
	    $tabla = "";
	    foreach ($datos as $value) 
	    {
	        $tabla .= str_pad($value, $espacio," ",STR_PAD_RIGHT);
	    }
	    return $tabla._EOL;
	}
	
	/**
	 * 
	 * @param string $numero
	 * @return string
	 */
	protected function formatnumero($numero)
	{		
		
		if(is_numeric($numero))
		{			
			if(stripos($numero,".") === false)
				return "$".$numero.".00";
			elseif((stripos($numero,".")+2) == strlen($numero))
				return "$".$numero."0";
			else 
				return "$".$numero;
		}
		else return $numero;
	}
}