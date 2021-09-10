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

    public static function ConstructorParametrizado($clave, $mail)
    {
        return new Usuario("unknown", $clave, $mail);
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

    public static function LeerUsuarios()
    {
        $archivo = fopen("usuarios.csv", "r");
        $array = array();

        while(($datos = fgetcsv($archivo)) !== false){

            $user = new Usuario($datos[0], $datos[1], $datos[2]);
            array_push($array, $user);

        }

        fclose($archivo);
        return $array;
    }

    public static function ArmarLista()
    {
        $array = self::LeerUsuarios();

        foreach ($array as $user) {
            echo "<ul>";
            echo "<li>" . $user->nombre . "</li>";
            echo "<li>" . $user->clave . "</li>";
            echo "<li>" . $user->mail . "</li>";
            echo "</ul>";
        }
    }

    public function Equals($user)
    {
        if($this->mail == $user->mail)
        {
            $retorno = 0;

            if($this->clave == $user->clave) 
            {
                $retorno = 1;

            }

        } else {

            $retorno = -1;
        }

        return $retorno;
    }

    public static function ValidarUsuario($u1)
    {
        $array = self::LeerUsuarios();

        foreach ($array as $user) {
            
            $data = $user->Equals($u1);
            
            if($data == 0 || $data == 1)
            {
                return $data;
            }
        }

        return $data;
    }
}


?>