<?php

include_once "AccesoDatos.php";

class Pizza 
{
    public $sabor;
    public $precio;
    public $tipo;
    public $cantidad;
    public $id;

    public function __construct()
    {

    }

    public static function CrearObjeto($sabor,$precio,$tipo, $cantidad, $id = 0)
    {
        $pizza = new Pizza();

        $pizza->sabor = $sabor;
        $pizza->precio = $precio;
        $pizza->tipo = $tipo;
        $pizza->cantidad = $cantidad;
        $pizza->precio = $precio;
        $pizza->id == 0 ? $pizza->id = random_int(1,10000) : $pizza->id = $id;

        return $pizza;
    }

    public function Equals($prod)
    {
        if($this->tipo == $prod->tipo && $this->sabor == $prod->sabor)
        {
            return true;
        } else{
            return false;
            
        }
    }

    public static function GuardarProducto($prod , $modo)
    {
        $archivo = fopen("Pizza.json", $modo);
        $retorno = false;

        if($archivo != false)
        {
            $store = fwrite($archivo, json_encode(get_object_vars($prod)) . "\n");

            if($store != false)
            {
                $retorno = true;
            }

            fclose($archivo);
        }

        return $retorno;
    }

    public static function LeerProductos()
    {
        $array = array();

        $archivo = fopen("Pizza.json", "r");

        if($archivo != false)
        {
            while(!feof($archivo))
            {
                $aux = json_decode(fgets($archivo), true);

                if($aux != null)
                {
                    $prod = self::CrearObjeto($aux['sabor'],$aux['precio'],$aux['tipo'],$aux['cantidad'],$aux['id']);
                    array_push($array, $prod);
                }
            }

            fclose($archivo);
        }

        return $array;
    }

    public static function GuardarImagen($p1)
    {
        $dir_subida = 'ImagenesDePizza/';

        if (!file_exists($dir_subida)) {
            mkdir('ImagenesDePizza/', 0777, true);
    
        }
    
        $extension = explode(".", $_FILES["imagen"]["name"]);
    
        $destino = $dir_subida . $p1->tipo . $p1->sabor . "." . $extension[1];
        move_uploaded_file($_FILES["imagen"]["tmp_name"], $destino);
    }

    public static function ValidarProducto($p1)
    {
        $array = self::LeerProductos();
        $retorno = true;
        $flag = true;

        foreach ($array as $prod) {
            
            if($prod->Equals($p1))
            {
                $prod->cantidad += $p1->cantidad;
                $prod->precio = $p1->precio;
                $retorno = false;
                break;
            }
        }

        if(!$retorno)
        {
            foreach ($array as $prod) {
                
                if(!$flag)
                {
                    self::GuardarProducto($prod, 'a');

                } else {
                    self::GuardarProducto($prod, 'w');
                    $flag = false;
                }
            }

        } else {

            self::GuardarProducto($p1, 'a');
        }

        if(isset($_FILES["imagen"]))
        {
            self::GuardarImagen($p1);
        }

        return $retorno;

    }

    public static function VerificarPizza($p1)
    {
        $retorno;
        $hayTipo = false;
        $haySabor = false;
        $array = self::LeerProductos();

        foreach ($array as $pizza) {
            
            if($pizza->Equals($p1))
            {
                $retorno = "Existe sabor y tipo";
                break;
            }
        }

        foreach ($array as $pizza) {
            
            if($pizza->sabor == $p1->sabor)
            {
                $haySabor = true;
                break;
            }
        }

        foreach ($array as $pizza) {
            
            if($pizza->tipo == $p1->tipo)
            {
                $hayTipo = true;
                break;
            }
        }

        if($haySabor == false){
            $retorno = "No hay sabor";
        }

        if($hayTipo == false){
            $retorno = "No hay tipo";
        }

        if($haySabor == false && $hayTipo == false){
            $retorno = "No existe ni tipo ni sabor";
        }

        return $retorno;
    }

    public static function CargarImagen($mail, $p1)
    {
        $dir_subida = 'ImagenesDeLaVenta/';

        if (!file_exists($dir_subida)) {
            mkdir('ImagenesDeLaVenta/', 0777, true);
    
        }
    
        $extension = explode(".", $_FILES["imagen"]["name"]);
        $nombre = explode("@", $mail);
    
        $fecha = date_create("now");
        $destino = $dir_subida . $p1->tipo . $p1->sabor . $nombre[0] . date_format($fecha, "dmY") . "." . $extension[1];
        move_uploaded_file($_FILES["imagen"]["tmp_name"], $destino);
    }

    public static function CrearVenta($p1, $mail)
    {
        $array = self::LeerProductos();
        $retorno = false;
        $flag = true;

        foreach ($array as $pizza) {
            
            if($pizza->Equals($p1) && $pizza->cantidad > $p1->cantidad)
            {
                $fecha = new DateTime('now');
                $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
                $consulta =$objetoAccesoDato->RetornarConsulta('INSERT INTO pizza (sabor, tipo, cantidad, fecha, pedido) VALUES (:sabor,:tipo,:cantidad,:fecha,:pedido)');
                $consulta->bindValue(':sabor',$p1->sabor, PDO::PARAM_STR);
                $consulta->bindValue(':tipo',$p1->tipo, PDO::PARAM_STR);
                $consulta->bindValue(':cantidad',$p1->cantidad, PDO::PARAM_INT);
                $consulta->bindValue(':pedido',random_int(1,10000), PDO::PARAM_INT);
                $consulta->bindValue(':fecha',$fecha->format('Y-m-d'), PDO::PARAM_STR);
                $consulta->bindValue(':sabor',$p1->sabor, PDO::PARAM_STR);
                $consulta->bindValue(':tipo',$p1->tipo, PDO::PARAM_STR);
                $consulta->execute();  

                $pizza->cantidad -= $p1->cantidad;
                if(isset($_FILES["imagen"]))
                {
                    self::CargarImagen($mail, $p1);
                }
                $retorno = true;
                break;
            }
        }
        
        if($retorno)
        {
            foreach ($array as $prod) {
                
                if(!$flag)
                {
                    self::GuardarProducto($prod, 'a');

                } else {
                    self::GuardarProducto($prod, 'w');
                    $flag = false;
                }
            }

        }

        return $retorno;


    }

    public static function CantidadTotal($fecha)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta('SELECT SUM(cantidad) AS cantidadTotal FROM pizza WHERE fecha = :fecha');
        $consulta->bindValue(':fecha', $fecha, PDO::PARAM_STR);
        $consulta->execute(); 
        return $consulta->fetch(PDO::FETCH_ASSOC);
    }

    public static function VentasEntreDosFechas($fechaUno, $fechaDos){

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM `pizza` WHERE `fecha` BETWEEN :fechaUno AND :fechaDos");
        $consulta->bindValue(':fechaUno', $fechaUno, PDO::PARAM_STR);
        $consulta->bindValue(':fechaDos', $fechaDos, PDO::PARAM_STR);
        $consulta->execute();			
        return $consulta->fetchAll(PDO::FETCH_CLASS, "Pizza");	

    }

    public static function VentasPorUsuario($user){

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM `pizza` WHERE `usuario` = :user");
        $consulta->bindValue(':user', $user, PDO::PARAM_STR);
        $consulta->execute();			
        return $consulta->fetchAll(PDO::FETCH_CLASS, "Pizza");	

    }

    
    public static function VentasPorSabor($sabor){

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM `pizza` WHERE `sabor` = :sabor");
        $consulta->bindValue(':sabor', $sabor, PDO::PARAM_STR);
        $consulta->execute();			
        return $consulta->fetchAll(PDO::FETCH_CLASS, "Pizza");	

    }

    public static function ModificarVentaParametros($usuario,$sabor,$tipo,$cantidad,$pedido)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE `pizza` SET `sabor`=:sabor,`tipo`=:tipo,`cantidad`=:cantidad,`usuario`=:usuario WHERE `pedido` = :pedido");
        $consulta->bindValue(':sabor',$sabor, PDO::PARAM_STR);
        $consulta->bindValue(':tipo',$tipo, PDO::PARAM_STR);
        $consulta->bindValue(':cantidad',$cantidad, PDO::PARAM_INT);
        $consulta->bindValue(':pedido',$pedido, PDO::PARAM_INT);
        $consulta->bindValue(':usuario',$usuario, PDO::PARAM_STR);
        $consulta->execute(); 
        return $consulta->rowCount();
    }

    public static function BorrarVenta($pedido)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("DELETE FROM `pizza` WHERE pedido = :pedido");
        $consulta->bindValue(':pedido',$pedido, PDO::PARAM_INT);
        $consulta->execute(); 
        return $consulta->rowCount();
    }

    public static function TraerUnaVenta($pedido)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM `pizza` WHERE pedido = :pedido");
        $consulta->bindValue(':pedido',$pedido, PDO::PARAM_INT);
        $consulta->execute(); 
        return $consulta->fetchObject('Pizza');
    }

    public static function MoverDirectorioFotografia($ruta){

        $dir = opendir("C:/xampp/htdocs/Noguera/clase07/ImagenesDeLaVenta/");
        $retorno = "No se pudo mover";

        if($file = readdir($dir) != false){

            if(copy("C:/xampp/htdocs/Noguera/clase07/ImagenesDeLaVenta/" . $ruta, "C:/xampp/htdocs/Noguera/clase07/BACKUPVENTAS/" . $ruta)){

                unlink("C:/xampp/htdocs/Noguera/clase07/ImagenesDeLaVenta/" . $ruta);
                $retorno = "Se ha cambiado la imagen de directorio";
            } 
            
        }

        closedir($dir);

        return $retorno;
    }

}


?>