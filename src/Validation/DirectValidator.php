<?php
namespace Marve\Ela\Validation;

class DirectValidator
{
    /**
     * 
     * @param string $name
     * @param int $minlength
     * @return string|boolean
     */
    public static function Name($name, $minlength = 4)
    {
        $name = self::utf8decode($name);// mb_convert_encoding($nombre,"UTF-8",mb_detect_encoding($nombre));//utf8_encode($nombre); //convertir � � y otros para examinar  
        $name = preg_replace("/\s+/", "", $name); // remover espacios 
        if(strlen($name) <= $minlength)
            return "Contiene pocos caracteres";
        $pattern = '/^[A-Za-z\x{00C0}-\x{00FF}][A-Za-z\x{00C0}-\x{00FF}\'\-]+([\ A-Za-z\x{00C0}-\x{00FF}][A-Za-z\x{00C0}-\x{00FF}\'\-]+)*/u';
        if (preg_match($pattern, $name)) 
        {
            return true;
        }
        return "Contiene caracteres no admitidos";          
    }
    
    /**
     * 
     * @param string $name
     * @param int $minlength
     * @return string|boolean
     */
    public static function User($name, $minlength = 4)
    {
        if(strlen($name) < $minlength)
            return "Contiene pocos caracteres";
        if (ctype_alnum($name))
        {
            if(strlen($name) >= $minlength)
                return true;
            else
                return "Contiene caracteres no admitidos";
        }     
        return "Contiene carateres no admitidos, use letras y numeros";  
    }
    
    /**
     * 
     * @param string $password
     * @return boolean|string
     */
    public static function Password($password)
    {
        if (preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{4,12}$/', $password) == 1)
        {
            return true;
        }
        else
        {
            return "Contiene caracteres no admitidos";
        }
    }
    
    /**
     * 
     * @param string $email
     * @return string|boolean
     */
    public static function Email($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false)
        {
            return "Email mal formado o invalido";
        }
        else
            return true;
    }
    
    /**
     * 
     * @param string $celular
     * @return string|boolean
     */
    public static function Telefone($celular)
    {
        // Filtrar numeros
        $filtro = filter_var($celular, FILTER_SANITIZE_NUMBER_INT);
        // Remover "-"
        $numeros = str_replace("-", "", $filtro);
        // Checar cantidad de numeros
        if (strlen($numeros) < 10 || strlen($numeros) > 14)
        {
            return "Numero invalido";
        }
        else
            return true;
    }
    
    public static function Rfc($rfc)
    {
        $regex = '/^[A-ZÑ]{3,4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])([A-Z\d]{3})$/';
        if(preg_match($regex, $rfc) === 1)
            return true;
        else return "RFC invalido";
    }
    public static function Barcode($barcode)
    {
        $barcode = preg_replace("/\s+/", "", $barcode);
        if(ctype_alnum($barcode))
            return true;
        elseif (ctype_digit($barcode))
            return true;
        elseif (ctype_alpha($barcode))
            return true;
        else return "Codigo invalido";
        //$token = new Acceso();
        //return $token->crearllave(64);
    }
    public static function Numero($number)
    {
        if(is_numeric($number))
            return true;
        else return "No es numerico";
    }

    /**
     * 
     * @param string $string 
     * @return array|string|false 
     */
    public static function utf8decode($string)
    {
        return mb_convert_encoding($string,"UTF-8",mb_detect_encoding($string));
    }
    
}

