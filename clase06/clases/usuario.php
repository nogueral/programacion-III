<?php

include_once "AccesoDatos.php";


class Usuario
{
    private $nombre;
    private $apellido;
    private $clave;
    private $mail;
    private $localidad;
    private $fecha_de_registro;
    private $id;

    public function __construct()
    {

    }

    public static function CrearObjeto($nombre='empty', $apellido='empty', $clave='empty', $mail='empty', $localidad='empty', $fecha_de_registro = 'empty', $id = 0)
    {
        $usuario = new Usuario();

        $usuario->nombre = $nombre;
        $usuario->apellido = $apellido;
        $usuario->clave = $clave;
        $usuario->mail = $mail;
        $usuario->localidad = $localidad;
        if($fecha_de_registro == 'empty')
        {
            $fecha_de_registro = new DateTime("now");
            $usuario->fecha_de_registro = $fecha_de_registro->format('Y-m-d');
        } else{
            $usuario->fecha_de_registro = $fecha_de_registro;
        }
        $usuario->id = $id;

        return $usuario;
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

    public function GuardarUsuarioBD()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta('INSERT INTO usuario(nombre, apellido, clave, mail, localidad, fecha_de_registro) VALUES (:nombre,:apellido,:clave,:mail,:localidad, :fecha_de_registro)');
        $consulta->bindValue(':nombre',$this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':apellido',$this->apellido, PDO::PARAM_STR);
        $consulta->bindValue(':clave',$this->clave, PDO::PARAM_STR);
        $consulta->bindValue(':mail',$this->mail, PDO::PARAM_STR);
        $consulta->bindValue(':localidad',$this->localidad, PDO::PARAM_STR);
        $consulta->bindValue(':fecha_de_registro',$this->fecha_de_registro, PDO::PARAM_STR);
        $consulta->execute();   
        return $consulta->rowCount();
    }

    public static function TraerTodosLosUsuarios()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta('SELECT * FROM usuario');
        $consulta->execute(); 
        $array = $consulta->fetchAll(PDO::FETCH_CLASS, 'Usuario');
        return $array;
    }

    public static function ArmarListaBD()
    {
        $array = self::TraerTodosLosUsuarios();

        foreach ($array as $user) {
            echo "<ul>";
            echo "<li>" . $user->id . "</li>";
            echo "<li>" . $user->nombre . "</li>";
            echo "<li>" . $user->apellido . "</li>";
            echo "<li>" . $user->clave . "</li>";
            echo "<li>" . $user->mail . "</li>";
            echo "<li>" . $user->localidad . "</li>";
            echo "<li>" . $user->fecha_de_registro . "</li>"; 
            echo "</ul>";
        }
    }

    public static function ValidarUsuarioBD($u1)
    {
        $array = self::TraerTodosLosUsuarios();

        foreach ($array as $user) {
            
            $data = $user->Equals($u1);
            
            if($data == 0 || $data == 1)
            {
                return $data;
            }
        }

        return $data;
    }

    public static function TraerUnUsuario($id)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM usuario WHERE id = :id");
        $consulta->bindValue(':id',$id, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->fetchObject('Usuario');
    }
}


?>