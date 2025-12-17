<?php
namespace Marve\Ela\MySql;

use Marve\Ela\Core\DateCalendar;
use Marve\Ela\Html\Form\Form;
use Marve\Ela\Html\Form\GrupoInput;
use Marve\Ela\Html\Form\Input;
use stdClass;

/**
 * @version 1_000
 * 2017
 * @author Martin Mata
 *
 */


class DateHelper
{				
	/**
	 * 
	 * @param string $begins
	 * @param string $ends
	 * @param string $columnDate
	 * @return stdClass|number
	 * 
	 */
	public static function range($begins, $ends, $columnDate)
	{
	    $range = new stdClass();
	    $range->range = "Desde: ".DateCalendar::toWords($begins)."  Hasta: ".DateCalendar::toWords($ends);
	    $range->where = "$columnDate between '".$begins."' AND '".$ends."'";
	    $tiempo =  explode("-",$begins);
	    $temp = explode("-", $ends);
	    $range->mespasado = str_replace("0","", $tiempo[1]);
	    $range->actual = str_replace("0","", $temp[1]);
	    $range->year = $temp[0];
	    return $range;
	    
	}
	
	
	public static function lastMonth($columnDate)
	{
	    $range = new stdClass();
	    $tiempo =  date("Y-n-d", strtotime("first day of previous month"));
	    $range->range = "Desde: ".DateCalendar::toWords($tiempo)."  Hasta: ".DateCalendar::toWords(date("Y-m-d"));
	    $range->where = "$columnDate >= DATE_ADD(LAST_DAY(DATE_SUB(NOW(), INTERVAL 2 MONTH)), INTERVAL 1 DAY)";	    
	    $temp = explode("-", $tiempo);
	    $range->mespasado = $temp[1];
	    $range->actual = $temp[1] *1 + 1;
	    $range->year = $temp[0];
	    return $range;	    
	}
	public static function thisMonth($columnDate)
	{
	    $range = new stdClass();
	    $tiempo =  date("Y-n-d", strtotime("first day of this month"));
	    $range->range = "Desde: ".DateCalendar::toWords($tiempo)."  Hasta: ".DateCalendar::toWords(date("Y-m-d"));
	    $range->where = "$columnDate >= DATE_ADD(LAST_DAY(DATE_SUB(NOW(), INTERVAL 1 MONTH)), INTERVAL 1 DAY)";
	    $temp = explode("-", $tiempo);	   
	    $range->actual = $temp[1] *1 + 1;
	    $range->year = $temp[0];
	    return $range;	    
	}
	
	public static function today($columnDate)
	{
	    $range = new stdClass();
	    $tiempo =  date("Y-n-d");
	    $range->range = "Hoy: ".DateCalendar::toWords($tiempo);
	    $range->where = "date($columnDate) = CURDATE()";
	    $temp = explode("-", $tiempo);
	    $range->actual = $temp[1];
	    $range->year = $temp[0];
	    return $range;
	}
	
	public static function datepicker($dateonly = true)
	{	
		    
		$FORMA = new Form(($dateonly)?3:4);
		$FORMA->fields("dateForma","dateForma");
		if($dateonly)
		{
			$FROM = new Input("text");
			$FROM->fields("datefrom","datefrom","Desde","datepicker")
			->hidden("hourfrom","hourfrom","00:01:00")
			->hidden("hourto","hourto","23:59:59");
		$FORMA->add($FROM);
			$TO = new GrupoInput("text");
			$TO->fields("dateto","dateto","Hasta","datepicker")			
			->button("","bi bi-search","search_date","");
		$FORMA->add($TO);
		}
		else
		{
			$FROM = new Input("text");
			$FROM->fields("datefrom","datefrom","Desde","datepicker");						
		$FORMA->add($FROM);
			$FROM = new Input("time");
			$FROM->fields("hourfrom","hourfrom","Hora")
			->step(1)->value("00:01");
		$FORMA->add($FROM);
			$TO = new Input("text");
			$TO->fields("dateto","dateto","Hasta","datepicker");			
		$FORMA->add($TO);
			$TO = new GrupoInput("time");
			$TO->fields("hourto","hourto","Hora")->step(1)->value("23:59")			
			->button("","bi bi-search","search_date","");
		$FORMA->add($TO);
		}
		$html = $FORMA->sumitButtonLabel("buscar")->noSubmit()->render();
		$html .= "<script type='text/javascript'>
            $(document).ready(function()
		      {
                $(document).on('change', '#datefrom', function()
                {
                    $('#dateto').val($('#datefrom').val());
                });
                $('#search_date').click(function()
	    		{
	    			window.location = '?datefrom='+jQuery('#datefrom').val()+' '+jQuery('#hourfrom').val()+'&dateto='+jQuery('#dateto').val()+' '+jQuery('#hourto').val();
                    return false;
	            });
              });  
        </script>";
		return $html;
	    		
	}			
}