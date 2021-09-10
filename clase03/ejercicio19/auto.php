<?php
/*Aplicación No 19 (Auto)
Realizar una clase llamada “Auto” que posea los siguientes atributos privados:

_color (String)
_precio (Double)
_marca (String).
_fecha (DateTime)

Realizar un constructor capaz de poder instanciar objetos pasándole como parámetros:

i. La marca y el color.
ii. La marca, color y el precio.
iii. La marca, color, precio y fecha.

Crear un método de clase para poder hacer el alta de un Auto, guardando los datos en un
archivo autos.csv.
Hacer los métodos necesarios en la clase Auto para poder leer el listado desde el archivo
autos.csv
Se deben cargar los datos en un array de autos.

Realizar un método de instancia llamado “AgregarImpuestos”, que recibirá un doble por
parámetro y que se sumará al precio del objeto.
Realizar un método de clase llamado “MostrarAuto”, que recibirá un objeto de tipo “Auto”
por parámetro y que mostrará todos los atributos de dicho objeto.
Crear el método de instancia “Equals” que permita comparar dos objetos de tipo “Auto”. Sólo
devolverá TRUE si ambos “Autos” son de la misma marca.
Crear un método de clase, llamado “Add” que permita sumar dos objetos “Auto” (sólo si son
de la misma marca, y del mismo color, de lo contrario informarlo) y que retorne un Double con
la suma de los precios o cero si no se pudo realizar la operación.
Ejemplo: $importeDouble = Auto::Add($autoUno, $autoDos);
En testAuto.php:
Crear dos objetos “Auto” de la misma marca y distinto color.
● Crear dos objetos “Auto” de la misma marca, mismo color y distinto precio.
● Crear un objeto “Auto” utilizando la sobrecarga restante.
● Utilizar el método “AgregarImpuesto” en los últimos tres objetos, agregando $ 1500
al atributo precio.
● Obtener el importe sumado del primer objeto “Auto” más el segundo y mostrar el
resultado obtenido.
● Comparar el primer “Auto” con el segundo y quinto objeto e informar si son iguales o
no.
● Utilizar el método de clase “MostrarAuto” para mostrar cada los objetos impares (1, 3,
5) 

LEANDRO NOGUERA
*/

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

    public static function GuardarAuto($a1){

        $archivo = fopen("autos.csv", "a");

        $array = array($a1->_marca, $a1->_color, $a1->_precio, $a1->_fecha->format("Y-m-d"));
        $comma_separated = implode(",", $array) . "\n";

        fwrite($archivo, $comma_separated);

        fclose($archivo);
    }

    public static function LeerAuto(){

        $archivo = fopen("autos.csv", "r");
        $array = array();

        while(($datos = fgetcsv($archivo)) !== false){

            $fecha = new DateTime($datos[3]);
            $auto = new Auto($datos[0], $datos[1], $datos[2], $fecha);
            array_push($array, $auto);

        }

        fclose($archivo);
        return $array;
    }
    

}
?>