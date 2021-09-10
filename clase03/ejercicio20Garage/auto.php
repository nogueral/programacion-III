<?php
class Auto{

    public $_color;
    public $_precio;
    public $_marca;
    public $_fecha;

    public function __construct($_marca, $_color, $_precio = 0, $_fecha = null){

        $this->_marca = $_marca;
        $this->_color = $_color;
        $this->_precio = $_precio;
        if($_fecha == null){
            $this->_fecha = new DateTime();
        } else{
            $this->_fecha = $_fecha;
        }
        
    }

    public function AgregarImpuestos($_precio){

        return $this->_precio += $_precio;
    }

    public static function MostrarAuto($a1){

        echo "Marca: " . $a1->_marca . "<br>";
        echo "Color: " . $a1->_color . "<br>";
        echo "Precio: " . $a1->_precio . "<br>";
        echo "Fecha: " . $a1->_fecha->format("Y-m-d") . "<br>";
    }

    public function Equals($a1){

        if($this->_marca == $a1->_marca){

            return true;

        } else {

            return false;
        }
    }

    public static function Add($a1, $a2){

        if($a1->Equals($a2) && $a1->_color == $a2->_color){

            return $a1->_precio + $a2->_precio;

        } else {

            echo "Los objetos no son del mismo color o marca <br>";
            return 0;
        }
    }
    

}
?>