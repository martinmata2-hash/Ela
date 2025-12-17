<?php


class VerificaCaptcha
{    

    public function __invoke($captcha, $version = 2)
    {        
        $url =  "https://www.google.com/recaptcha/api/siteverify";
        $datos =[
            "secret"=> ($version == 2)?"reCaptchaSecretev2":"reCaptchaSecretev3",
            "response"=>$captcha
        ];
     
        $opciones = array(
            "http"=>array(
                "header"=>"Content-type: application/x-www-form-urlencoded\r\n",
                "method"=>"POST",
                "content"=>http_build_query($datos)
                )
            );
        $contexto = stream_context_create($opciones);        
        $resultado = file_get_contents($url, false, $contexto);
        if($resultado === false)        
            return false;
        $resultado = json_decode($resultado);        
        { 
            if(isset($resultado->score))
                if($resultado->score <= 0.1)
                {
                    //Destruir session y sacar al usuario
                    
                    return false;
                }           
            return $resultado->success;
        }
    }

}
