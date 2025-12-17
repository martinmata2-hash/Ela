<?php 

/**
 * @version 2024_1
 * 2017
 * @author Martin Mata
 */
namespace Marve\Ela\Core;

use DateTime;

class DateCalendar
{
    /**
     * Regresa la fecha en letras   Lunes, 4 de Julio del 2014
     * @param string $date
     * @return string
     */
    static function toWords($date)
    {
        $stampa =  strtotime($date);
        $week_days = array ("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado");
        $months = array ("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $year_now = date ("Y",$stampa); $month_now = date ("n",$stampa); $day_now = date ("j",$stampa); $week_day_now = date ("w", $stampa);
        $date = $week_days[$week_day_now] . ", " . $day_now . " de " . $months[$month_now] . " de " . $year_now;
        return $date;
    }
    /**
     * agrega minutos a la hora que se da,
     *	@param string $datetime
     *	@param int $add minutos a agregar
     *	@return string
     */
    static function addMinutes($hora, $add)
    {
        $agregar = "+$add minutes";
        return date('Y-m-d H:i:s', strtotime($agregar, strtotime($hora)));
    }
    
    /**
     * agrega dias a la fecha que se da,
     *	@param string $date
     *	@param int $add dias a agregar
     *	@return string
     */
    static function addDays($date, $add)
    {
        $agregar = "+$add days";
        return date('Y-m-d', strtotime($agregar, strtotime($date)));
    }
    
    static function addMonths($date, $add)
    {
        $agregar = "+$add months";
        return date('Y-m-d', strtotime($agregar, strtotime($date)));
    }

     /**
     *
     * @param int $month
     * @return string
     */
    static function monthName($month)
    {
        $months = array ("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $date = $months[$month];
        return $date;
    }
    
    /**
     * 
     * @param string $date
     * @return string
     */
    static function month($date)
    {
        $stampa =  strtotime($date);       
        $months = array ("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $month_now = date ("n",$stampa); 
        $date = $months[$month_now];
        return $date;
    }
    /**
     *
     * @param string $date
     * @return string
     */
    static function year($date)
    {
        $stampa =  strtotime($date);   
        $date = date ("Y",$stampa);
        return $date;
    }
    
    /**
     * 
     * @param string $date1
     * @param string $date2
     * @return number
     */
    static function diffDays($date1,$date2)
    {
        $diff = strtotime($date1) - strtotime($date2);        
        return floor($diff/3600/24);
    }
    
    /**
     * Diferencia en horas 
     * @param mixed $date1
     * @param mixed $date2
     * @return int
     */
    static function diffHours($date1,$date2)
    {
        $horaEvento = new DateTime($date2);
        $now = new DateTime($date1);
        $hour = $horaEvento->diff($now,true);
        return $hour->h;    
    }

    /**
     * ahora
     * @return string
     */
    static function now()
    {
        return date("Y-m-d H:i:s");
    }

    /**
     * hora del dia
     * @param bool $nosegundos
     * @return string
     */
    static function time(bool $nosegundos = false)
    {
        return ($nosegundos)?date("H:i"):date("H:i:s");
    }
}