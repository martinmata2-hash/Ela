<?php
namespace Marve\Ela\Core;

/**
 * Codificar y decodificar strings
 * @author Marti
 *
 */
class Encode
{

    public static function sha1md5encode($value)
    {
        return md5(sha1($value));
    }
    // Updated code from comments
    public static function encode($value)
    {
        if (! $value)
        {
            return false;
        }

        $key = sha1('EnCRypT10nK#Y!RiSRNn');
        $strLen = strlen($value);
        $keyLen = strlen($key);
        $j = 0;
        $crypttext = '';

        for ($i = 0; $i < $strLen; $i ++)
        {
            $ordStr = ord(substr($value, $i, 1));
            if ($j == $keyLen)
            {
                $j = 0;
            }
            $ordKey = ord(substr($key, $j, 1));
            $j ++;
            $crypttext .= strrev(base_convert(dechex($ordStr + $ordKey), 16, 36));
        }

        return $crypttext;
    }

    public static function decode($value)
    {
        if (! $value)
        {
            return false;
        }

        $key = sha1('EnCRypT10nK#Y!RiSRNn');
        $strLen = strlen($value);
        $keyLen = strlen($key);
        $j = 0;
        $decrypttext = '';

        for ($i = 0; $i < $strLen; $i += 2)
        {
            $ordStr = hexdec(base_convert(strrev(substr($value, $i, 2)), 36, 16));
            if ($j == $keyLen)
            {
                $j = 0;
            }
            $ordKey = ord(substr($key, $j, 1));
            $j ++;
            $decrypttext .= chr($ordStr - $ordKey);
        }

        return $decrypttext;
    }
    
    public static function hashPassword($password)
    {
        $options = [
            'cost' => 11
        ];
        return password_hash($password, PASSWORD_BCRYPT, $options);
    }
    
    public static function verifyPassword($hash, $password)
    {
        return password_verify($password, $hash);
    }

    /**
     * Crea una cadena aleatoria con un numero de caracteres
     *
     * @param int $length
     * @return string clave de $lenth caracteres
     */
    public static function createPass($length = 16)
    {
        if ($length <= 0) {
            return false;
        }
        $code = "";
        $chars = "abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
        srand((double) microtime() * 1000000);
        for ($i = 0; $i < $length; $i ++) {
            $code = $code . substr($chars, rand() % strlen($chars), 1);
        }
        return $code;
    }

    public static function createPass2($length = 16)
    {
        if ($length <= 0) {
            return false;
        }
        $code = "";
        $chars = "abcdef123456789";
        srand((double) microtime() * 1000000);
        for ($i = 0; $i < $length; $i ++) {
            $code = $code . substr($chars, rand() % strlen($chars), 1);
        }
        return $code;
    }
    
    public static function createIdCCP($folio)
    {
        $id = "CCC".self::createPass2(5)."-".self::createPass2(4)."-".self::createPass2(4)."-".self::createPass2(4)."-";
        $id .= str_pad($folio, 12, '0', STR_PAD_LEFT);
        return $id;
    }

    public static function utf8($string)
    {
        if (mb_detect_encoding($string, 'UTF-8', true)) 
        {
            $string = mb_convert_encoding($string, 'ISO-8859-1', 'UTF-8');
        }
        return $string;
    }

}