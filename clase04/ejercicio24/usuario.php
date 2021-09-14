<?php
class Usuario
{
    private $nombre;
    private $clave;
    private $mail;
    private $id;
    private $fecha;
    private $rutaArchivo;

    public function __construct($nombre, $clave, $mail, $id = 0, $fecha = 'empty', $rutaArchivo = 'empty')
    {
        $this->nombre = $nombre;
        $this->clave = $clave;
        $this->mail = $mail;
        $this->id != 0 ? $this->id = $id : $this->id = random_int(1, 10000);
        $this->rutaArchivo = $rutaArchivo;

        if($fecha == 'empty')
        {
            $fecha = new DateTime("now");
            $this->fecha = $fecha->format('d-m-Y');
        } else{
            $this->fecha = $fecha;
        }

    }

    public static function GuardarUsuario($user, $path)
    {
        $retorno = false;

        if(str_contains($path, '.csv'))
        {
            $archivo = fopen($path, "a");

            if($archivo != false)
            {
                $array = array($user->nombre, $user->clave, $user->mail, $user->id, $user->fecha, $user->rutaArchivo);
                $comma_separated = implode(",", $array) . "\n";

                if((fwrite($archivo, $comma_separated)) != false)
                {
                    $retorno = true;
                }
        
                fclose($archivo);
            }

            return $retorno;
        }

        if(str_contains($path, '.json'))
        {
            $archivo = fopen($path, "a");

            if($archivo != false)
            {
                $store = fwrite($archivo, json_encode(get_object_vars($user)) . "\n");

                if($store != false)
                {
                    $retorno = true;
                }

                fclose($archivo);
            }

            return $retorno;
        }

        return $retorno;

    }

    public function GuardarArchivo()
    {
        $destino = 'usuario/fotos/';

        if (!file_exists($destino)) {
            mkdir('usuario/fotos/', 0777, true);
    
        }
    
        $extension = explode(".", $_FILES["archivo"]["name"]);
    
        $fecha = date_create("now");
        $destino = $destino . date_format($fecha, "dmY") . $this->nombre . "." . $extension[1];
        move_uploaded_file($_FILES["archivo"]["tmp_name"], $destino);

        $this->rutaArchivo = $destino;
    }

    public static function LeerUsuarios($path)
    {
        $array = array();

        if(str_contains($path, '.csv'))
        {
            $archivo = fopen($path, "r");

            if($archivo != false)
            {
                while(($datos = fgetcsv($archivo)) !== false)
                {

                    $user = new Usuario($datos[0], $datos[1], $datos[2], $datos[3], $datos[4], $datos[5]);
                    array_push($array, $user);

                }

                fclose($archivo);
            }


        }

        if(str_contains($path, '.json'))
        {
            $archivo = fopen($path, "r");

            if($archivo != false)
            {
                while(!feof($archivo))
                {
                    $aux = json_decode(fgets($archivo), true);

                    if($aux != null)
                    {
                        $user = new Usuario($aux['nombre'],$aux['clave'],$aux['mail'],$aux['id'],$aux['fecha'],$aux['rutaArchivo']);
                        array_push($array, $user);
                    }
                }

                fclose($archivo);
            }

        }

        return $array;

    }

    public static function ArmarLista($path)
    {
        $array = self::LeerUsuarios($path);

        foreach ($array as $user) {
            echo "<ul>";
            echo "<li>" . $user->nombre . "</li>";
            echo "<li>" . $user->clave . "</li>";
            echo "<li>" . $user->mail . "</li>";
            echo "<li>" . $user->id . "</li>";
            echo "<li>" . $user->fecha . "</li>";
            echo "<li><img src='$user->rutaArchivo' alt='Imagen del usuario'></li>";  
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