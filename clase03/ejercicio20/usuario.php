<?php
class Usuario
{
    private $nombre;
    private $clave;
    private $mail;

    public function __construct($nombre, $clave, $mail)
    {
        $this->nombre = $nombre;
        $this->clave = $clave;
        $this->mail = $mail;
    }

    public static function GuardarUsuario($user)
    {
        $archivo = fopen("usuarios.csv", "a");
        $retorno = false;

        if($archivo != false)
        {
            $array = array($user->nombre, $user->clave, $user->mail);
            $comma_separated = implode(",", $array) . "\n";

            if((fwrite($archivo, $comma_separated)) != false)
            {
                $retorno = true;
            }
    
            fclose($archivo);
        }

        return $retorno;
    }
}


?>