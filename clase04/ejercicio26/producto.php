<?php
class Producto
{
    private $codigoBarra;
    private $nombre;
    private $tipo;
    private $stock;
    private $precio;
    private $id;


    public function __construct($codigoBarra,$nombre,$tipo,$stock,$precio,$id = 0)
    {
        $this->codigoBarra = $codigoBarra;
        $this->nombre = $nombre;
        $this->tipo = $tipo;
        $this->stock = $stock;
        $this->precio = $precio;
        $this->id == 0 ? $this->id = random_int(1,10000) : $this->id = $id;
    }

    public static function ConstructorParametrizado($codigoBarra)
    {
        return new Producto($codigoBarra,"empty","empty","empty","empty",-1);
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
        return $this->codigoBarra == $prod->codigoBarra ? true : false;
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
                    $prod = new Producto($aux['codigoBarra'],$aux['nombre'],$aux['tipo'],$aux['stock'],$aux['precio'],$aux['id']);
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
}


?>