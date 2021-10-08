<?php

include_once "AccesoDatos.php";

class Venta
{
    private $id_usuario;
    private $id_producto;
    private $fecha_de_venta;
    private $cantidad;
    private $codigo;
    private $id;

    public function __construct()
    {

    }

    public static function CrearVenta($id_usuario, $cantidad, $codigo, $id_producto)
    {
        $venta = new Venta();
        
        $venta->id_usuario = $id_usuario;
        $venta->cantidad = $cantidad;
        $venta->codigo = $codigo;
        $fecha = new DateTime('now');
        $venta->fecha_de_venta = $fecha->format('Y-m-d');
        $venta->id_producto = $id_producto;

        return $venta;
    }

    public static function GuardarVenta($venta)
    {
        $archivo = fopen("ventas.json", "a");
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

    public static function TraerTodasLasVentas()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta('SELECT * FROM venta');
        $consulta->execute(); 
        $array = $consulta->fetchAll(PDO::FETCH_CLASS, 'Venta');
        return $array;
    }

    public static function ArmarLista($array)
    {

        foreach ($array as $venta) {
            echo "<ul>";
            echo "<li>" . $venta->id . "</li>";
            echo "<li>" . $venta->id_usuario . "</li>";
            echo "<li>" . $venta->id_producto . "</li>";
            echo "<li>" . $venta->cantidad . "</li>";
            echo "<li>" . $venta->fecha_de_venta . "</li>";
            echo "</ul>";
        }
    }

    public function GuardarVentaBD()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta('INSERT INTO venta(id, id_producto, id_usuario, cantidad, fecha_de_venta) VALUES (:id,:id_producto,:id_usuario,:cantidad,:fecha_de_venta)');
        $consulta->bindValue(':id',$this->id, PDO::PARAM_INT);
        $consulta->bindValue(':id_producto',$this->id_producto, PDO::PARAM_INT);
        $consulta->bindValue(':id_usuario',$this->id_usuario, PDO::PARAM_INT);
        $consulta->bindValue(':cantidad',$this->cantidad, PDO::PARAM_INT);
        $consulta->bindValue(':fecha_de_venta',$this->fecha_de_venta, PDO::PARAM_STR);
        $consulta->execute();   
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    public static function TraerTodasLasVentasPorCantidad($min, $max)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta('SELECT * FROM venta WHERE cantidad BETWEEN :minimo AND :maximo');
        $consulta->bindValue(':minimo',$min, PDO::PARAM_INT);
        $consulta->bindValue(':maximo',$max, PDO::PARAM_INT);
        $consulta->execute(); 
        $array = $consulta->fetchAll(PDO::FETCH_CLASS, 'Venta');
        return $array;
    }

    public static function MostrarNombres()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("SELECT usuario.nombre as nombreUsuario , producto.nombre as nombreProducto FROM `usuario` INNER JOIN `venta` ON usuario.id = venta.id_usuario INNER JOIN `producto` ON producto.id = venta.id_producto;");
        $consulta->execute();			
        return $consulta->fetchAll(PDO::FETCH_OBJ);
    }

    public static function MontoPorVenta(){

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("SELECT venta.cantidad*producto.precio as monto FROM `venta` INNER JOIN `producto` ON venta.id_producto = producto.id");
        $consulta->execute();			
        return $consulta->fetchAll(PDO::FETCH_OBJ);	

    }

    public static function CantidadTotalPorUsuario($producto, $usuario){

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("SELECT SUM(`cantidad`) as 'cantidadTotal' FROM `venta` WHERE `id_producto` = :producto AND `id_usuario` = :usuario");
        $consulta->bindValue(':producto', $producto, PDO::PARAM_INT);
        $consulta->bindValue(':usuario', $usuario, PDO::PARAM_INT);
        $consulta->execute();			
        return $consulta->fetchAll(PDO::FETCH_OBJ);	
    }

    public static function ProductosPorLocalidad($localidad){

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("SELECT id_producto FROM `venta` INNER JOIN `usuario` ON usuario.id = venta.id_usuario WHERE usuario.localidad = :localidad
        ");
        $consulta->bindValue(':localidad', $localidad, PDO::PARAM_STR);
        $consulta->execute();			
        return $consulta->fetchAll(PDO::FETCH_OBJ);	

    }

    public static function VentasEntreDosFechas($fechaUno, $fechaDos){

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM `venta` WHERE `fecha_de_venta` BETWEEN :fechaUno AND :fechaDos");
        $consulta->bindValue(':fechaUno', $fechaUno, PDO::PARAM_STR);
        $consulta->bindValue(':fechaDos', $fechaDos, PDO::PARAM_STR);
        $consulta->execute();			
        return $consulta->fetchAll(PDO::FETCH_CLASS, "venta");	

    }
}


?>