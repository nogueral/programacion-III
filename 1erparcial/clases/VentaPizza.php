<?php
include_once "AccesoDatos.php";
include_once "Pizza.php";

class VentaPizza{

    public $id;
    public $sabor;
    public $tipo;
    public $fecha;
    public $pedido;
    public $cantidad;
    public $usuario;
    public $ruta;

    public function __construct()
    {

    }

    public static function CrearObjeto($sabor,$precio,$tipo, $cantidad, $usuario, $id = 0)
    {
        $venta = new VentaPizza();

        $venta->sabor = $sabor;
        $venta->usuario = $usuario;
        $venta->tipo = $tipo;
        $venta->cantidad = $cantidad;
        $venta->precio = $precio;
        $venta->id = $id;

        return $venta;
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
        $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM `pizza` WHERE `fecha` BETWEEN :fechaUno AND :fechaDos ORDER BY sabor");
        $consulta->bindValue(':fechaUno', $fechaUno, PDO::PARAM_STR);
        $consulta->bindValue(':fechaDos', $fechaDos, PDO::PARAM_STR);
        $consulta->execute();			
        return $consulta->fetchAll(PDO::FETCH_CLASS, "VentaPizza");	

    }

    public static function VentasPorUsuario($user){

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM `pizza` WHERE `usuario` = :user");
        $consulta->bindValue(':user', $user, PDO::PARAM_STR);
        $consulta->execute();			
        return $consulta->fetchAll(PDO::FETCH_CLASS, "VentaPizza");	

    }

    public static function VentasPorSabor($sabor){

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM `pizza` WHERE `sabor` = :sabor");
        $consulta->bindValue(':sabor', $sabor, PDO::PARAM_STR);
        $consulta->execute();			
        return $consulta->fetchAll(PDO::FETCH_CLASS, "VentaPizza");	

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

    public static function TraerUnaVenta($pedido)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM `pizza` WHERE pedido = :pedido");
        $consulta->bindValue(':pedido',$pedido, PDO::PARAM_INT);
        $consulta->execute(); 
        return $consulta->fetchObject('VentaPizza');
    }

    public static function BorrarVenta($pedido)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("DELETE FROM `pizza` WHERE pedido = :pedido");
        $consulta->bindValue(':pedido',$pedido, PDO::PARAM_INT);
        $consulta->execute(); 
        return $consulta->rowCount();
    }

    public static function MoverDirectorioFotografia($ruta){

        $dir = opendir("C:/xampp/htdocs/Noguera/1erparcial/ImagenesDeLaVenta/");
        $retorno = "No se pudo mover";

        if($file = readdir($dir) != false){

            if(copy("C:/xampp/htdocs/Noguera/1erparcial/ImagenesDeLaVenta/" . $ruta, "C:/xampp/htdocs/Noguera/1erparcial/BACKUPVENTAS/" . $ruta)){

                unlink("C:/xampp/htdocs/Noguera/1erparcial/ImagenesDeLaVenta/" . $ruta);
                $retorno = "Se ha cambiado la imagen de directorio";
            } 
            
        }

        closedir($dir);

        return $retorno;
    }

    public static function GuardarDevolucion($venta)
    {
        $archivo = fopen("devoluciones.json", "a");
        $retorno = false;

        if($archivo != false)
        {
            $store = fwrite($archivo, json_encode(get_object_vars($venta)) . "\n");

            if($store != false)
            {
                $retorno = true;
            }

            fclose($archivo);
        }

        return $retorno;
    }

    public static function GuardarImagen($venta)
    {
        $dir_subida = 'ImagenesDeDevoluciones/';

        if (!file_exists($dir_subida)) {
            mkdir('ImagenesDeDevoluciones/', 0777, true);
    
        }
    
        $extension = explode(".", $_FILES["imagen"]["name"]);
    
        $destino = $dir_subida . $venta->pedido . "." . $extension[1];
        move_uploaded_file($_FILES["imagen"]["tmp_name"], $destino);
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

        $ruta = $p1->tipo . $p1->sabor . $nombre[0] . date_format($fecha, "dmY") . "." . $extension[1];

        return $ruta;
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

    public static function CrearVenta($p1, $mail)
    {
        $array = self::LeerProductos();
        $retorno = false;
        $flag = true;

        foreach ($array as $pizza) {
            
            if($pizza->Equals($p1) && $pizza->cantidad > $p1->cantidad)
            {
                
                $ruta;

                if(isset($_FILES["imagen"]))
                {
                    $ruta = self::CargarImagen($mail, $p1);
                } else{
                    $ruta = "unknown";
                }

                $fecha = new DateTime('now');
                $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
                $consulta =$objetoAccesoDato->RetornarConsulta('INSERT INTO pizza (sabor, tipo, cantidad, fecha, pedido, usuario, ruta) VALUES (:sabor,:tipo,:cantidad,:fecha,:pedido, :usuario, :ruta)');
                $consulta->bindValue(':sabor',$p1->sabor, PDO::PARAM_STR);
                $consulta->bindValue(':tipo',$p1->tipo, PDO::PARAM_STR);
                $consulta->bindValue(':cantidad',$p1->cantidad, PDO::PARAM_INT);
                $consulta->bindValue(':pedido',random_int(1,10000), PDO::PARAM_INT);
                $consulta->bindValue(':fecha',$fecha->format('Y-m-d'), PDO::PARAM_STR);
                $consulta->bindValue(':sabor',$p1->sabor, PDO::PARAM_STR);
                $consulta->bindValue(':tipo',$p1->tipo, PDO::PARAM_STR);
                $consulta->bindValue(':usuario',$p1->usuario, PDO::PARAM_STR);
                $consulta->bindValue(':ruta',$ruta, PDO::PARAM_STR);
                $consulta->execute();  

                $retorno = true;
                break;
            }
        }
        
        if($retorno)
        {
            foreach ($array as $prod) {
                
                if(!$flag)
                {
                    Pizza::GuardarProducto($prod, 'a');

                } else {
                    Pizza::GuardarProducto($prod, 'w');
                    $flag = false;
                }
            }

        }

        return $retorno;


    }

}

?>