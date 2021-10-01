<?php
include_once "AccesoDatos.php";

class Producto
{
    private $codigo_de_barra;
    private $nombre;
    private $tipo;
    private $stock;
    private $precio;
    private $id;
    private $fecha_de_creacion;
    private $fecha_de_modificacion;

    public function __construct()
    {

    }

    public static function CrearObjeto($codigo_de_barra,$nombre,$tipo,$stock,$precio)
    {
        $prod = new Producto();

        $prod->codigo_de_barra = $codigo_de_barra;
        $prod->nombre = $nombre;
        $prod->tipo = $tipo;
        $prod->stock = $stock;
        $prod->precio = $precio;
        $fecha = new DateTime('now');
        $prod->fecha_de_creacion = $fecha->format('Y-m-d');
        $prod->fecha_de_modificacion = $fecha->format('Y-m-d');

        return $prod;
    }

    public function GetId()
    {
        return $this->id;
    }

    public static function ConstructorParametrizado($codigo_de_barra)
    {
        return new Producto($codigo_de_barra,"empty","empty","empty","empty",-1);
    }

    public static function GuardarProducto($prod , $modo)
    {
        $archivo = fopen("productos.json", $modo);
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

    public function Equals($prod)
    {
        return $this->codigo_de_barra == $prod->codigo_de_barra ? true : false;
    }

    public function ValidarStock($stock)
    {
        return $this->stock >= $stock ? true : false;
    }

    public static function ProductoExistente($p1, $stock)
    {
        $array = self::LeerProductos();

        foreach ($array as $prod) {
            
            if($prod->Equals($p1) && $prod->ValidarStock($stock))
            return true;
        }

        return false;
    }

    public static function LeerProductos()
    {
        $array = array();

        $archivo = fopen("productos.json", "r");

        if($archivo != false)
        {
            while(!feof($archivo))
            {
                $aux = json_decode(fgets($archivo), true);

                if($aux != null)
                {
                    $prod = new Producto($aux['codigo_de_barra'],$aux['nombre'],$aux['tipo'],$aux['stock'],$aux['precio'],$aux['id']);
                    array_push($array, $prod);
                }
            }

            fclose($archivo);
        }

        return $array;
    }

    public static function ValidarProducto($p1)
    {
        $array = self::LeerProductos();
        $retorno = true;
        $flag = true;

        foreach ($array as $prod) {
            
            if($prod->Equals($p1))
            {
                $prod->stock += $p1->stock;
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

        return $retorno;

    }

    public static function ModificarStock($p1, $cantidad)
    {
        $array = self::LeerProductos();
        $retorno = false;
        $flag = true;

        foreach ($array as $prod) {
            
            if($prod->Equals($p1))
            {
                $prod->stock -= $cantidad;
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

    public static function TraerTodosLosProductos()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta('SELECT * FROM producto');
        $consulta->execute(); 
        $array = $consulta->fetchAll(PDO::FETCH_CLASS, 'Producto');
        return $array;
    }

    public static function ArmarLista($array)
    {

        foreach ($array as $prod) {
            echo "<ul>";
            echo "<li>" . $prod->id . "</li>";
            echo "<li>" . $prod->codigo_de_barra . "</li>";
            echo "<li>" . $prod->nombre . "</li>";
            echo "<li>" . $prod->tipo . "</li>";
            echo "<li>" . $prod->stock . "</li>";
            echo "<li>" . $prod->precio . "</li>";
            echo "<li>" . $prod->fecha_de_creacion . "</li>";
            echo "<li>" . $prod->fecha_de_modificacion . "</li>";
            echo "</ul>";
        }
    }

    public static function TraerUnProducto($codigo_de_barra)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM producto WHERE codigo_de_barra = :codigo_de_barra");
        $consulta->bindValue(':codigo_de_barra',$codigo_de_barra, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->fetchObject('Producto');
    }

    

    public function GuardarProductoBD()
    {
        $prod = self::TraerUnProducto($this->codigo_de_barra);
        $retorno = -1;

        if($prod != false)
        {
            $prod->stock += $this->stock;
            $fecha = new DateTime('now');
            $prod->fecha_de_modificacion = $fecha->format('Y-m-d');
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE producto SET stock = :stock, fecha_de_modificacion = :fecha_de_modificacion WHERE codigo_de_barra = :codigo_de_barra");
            $consulta->bindValue(':codigo_de_barra',$prod->codigo_de_barra, PDO::PARAM_INT);
            $consulta->bindValue(':stock',$prod->stock, PDO::PARAM_INT);
            $consulta->bindValue(':fecha_de_modificacion',$prod->fecha_de_modificacion, PDO::PARAM_STR);
            $consulta->execute(); 
            $retorno = 0;

        } else {

            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta =$objetoAccesoDato->RetornarConsulta('INSERT INTO producto (codigo_de_barra, nombre, tipo, stock, precio, fecha_de_creacion, fecha_de_modificacion) VALUES (:codigo_de_barra,:nombre,:tipo,:stock,:precio, :fecha_de_creacion, :fecha_de_modificacion)');
            $consulta->bindValue(':codigo_de_barra',$this->codigo_de_barra, PDO::PARAM_INT);
            $consulta->bindValue(':nombre',$this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':tipo',$this->tipo, PDO::PARAM_STR);
            $consulta->bindValue(':stock',$this->stock, PDO::PARAM_INT);
            $consulta->bindValue(':precio',$this->precio, PDO::PARAM_INT);
            $consulta->bindValue(':fecha_de_creacion',$this->fecha_de_creacion, PDO::PARAM_STR);
            $consulta->bindValue(':fecha_de_modificacion',$this->fecha_de_modificacion, PDO::PARAM_STR);
            $consulta->execute();  
            $retorno = 1; 
        }

        return $retorno;
    }

    public function ModificarProducto()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE producto SET nombre = :nombre, tipo = :tipo, stock = :stock, precio = :precio, fecha_de_modificacion = :fecha_de_modificacion WHERE codigo_de_barra = :codigo_de_barra");
        $consulta->bindValue(':codigo_de_barra',$this->codigo_de_barra, PDO::PARAM_INT);
        $consulta->bindValue(':nombre',$this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':tipo',$this->tipo, PDO::PARAM_STR);
        $consulta->bindValue(':stock',$this->stock, PDO::PARAM_INT);
        $consulta->bindValue(':precio',$this->precio, PDO::PARAM_INT);
        $consulta->bindValue(':fecha_de_modificacion',$this->fecha_de_modificacion, PDO::PARAM_STR);
        $consulta->execute();
        return $consulta->rowCount();
    }

    public static function TraerTodosLosProductosOrdenados($order)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        if($order == 1)
        {
            $consulta =$objetoAccesoDato->RetornarConsulta('SELECT * FROM producto ORDER BY nombre DESC');
        } else{
            $consulta =$objetoAccesoDato->RetornarConsulta('SELECT * FROM producto ORDER BY nombre ASC');
        }
        
        $consulta->execute(); 
        
        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Producto');
    }

    public static function StockTotalPorFechas($min, $max)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta('SELECT SUM(stock) AS cantidadTotal FROM producto WHERE fecha_de_creacion BETWEEN :minimo AND :maximo');
        $consulta->bindValue(':minimo',$min, PDO::PARAM_STR);
        $consulta->bindValue(':maximo',$max, PDO::PARAM_STR);
        $consulta->execute(); 
        return $consulta->fetch(PDO::FETCH_ASSOC);
    }

    public static function TraerProductos($limit)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta('SELECT * FROM producto LIMIT :limite');
        $consulta->bindValue(':limite',$limit, PDO::PARAM_INT);
        $consulta->execute(); 
        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Producto');
    }

}


?>