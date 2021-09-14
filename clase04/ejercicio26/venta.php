<?php
class Venta
{
    private $idUsuario;
    private $cantidad;
    private $codigo;
    private $id;

    public function __construct($idUsuario, $cantidad, $codigo)
    {
        $this->idUsuario = $idUsuario;
        $this->cantidad = $cantidad;
        $this->codigo = $codigo;
        $this->id = random_int(1,10000);
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
    
}


?>