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

    public static function ArmarLista()
    {
        $array = self::TraerTodasLasVentas();

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

    
}


?>