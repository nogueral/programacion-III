<?php
class Cupon{

    public $id;
    public $descuento;
    public $causa;
    public $estado;
    public $importe;
    public $descuentoAplicado;

    public function __construct()
    {

    }

    public static function CrearObjeto($descuento, $causa, $id = 0){

        $cupon = new Cupon();

        $cupon->id = $id != 0 ? $id : random_int(1,10000);
        $cupon->descuento = $descuento;
        $cupon->causa = $causa;
        $cupon->estado = true;
        $cupon->importe = -1;
        $cupon->descuentoAplicado = -1;

        return $cupon;
    }

    public static function GuardarCupon($cupon, $modo)
    {
        $archivo = fopen("cupones.json", $modo);
        $retorno = false;

        if($archivo != false)
        {
            $store = fwrite($archivo, json_encode(get_object_vars($cupon)) . "\n");

            if($store != false)
            {
                $retorno = true;
            }

            fclose($archivo);
        }

        return $retorno;
    }

    public static function LeerCupones()
    {
        $array = array();

        $archivo = fopen("cupones.json", "r");

        if($archivo != false)
        {
            while(!feof($archivo))
            {
                $aux = json_decode(fgets($archivo), true);

                if($aux != null)
                {
                    $cupon = self::CrearObjeto($aux['descuento'],$aux['causa'],$aux['id']);
                    array_push($array, $cupon);
                }
            }

            fclose($archivo);
        }



        return $array;
    }

    public static function UsarCupon($id, $importe){

        $array = self::LeerCupones();
        $flag = true;
        $retorno = false;

        foreach ($array as $cupon) {
          
            if($cupon->id == $id){
                $cupon->estado = false;
                $cupon->importe = $importe;
                $cupon->descuentoAplicado = ($importe*10)/100;
                $retorno = true;
                break;
            }
        }

        if($retorno)
        {
            foreach ($array as $cupon) {
          
                if($flag){
    
                    self::GuardarCupon($cupon, 'w');
                    $flag = false;
                } else {
                    self::GuardarCupon($cupon, 'a');
                }
            }
        }

        return $retorno;
    }
}


?>