<?php 
/*Aplicación No 18 (Auto - Garage)
Crear la clase Garage que posea como atributos privados:

_razonSocial (String)
_precioPorHora (Double)
_autos (Autos[], reutilizar la clase Auto del ejercicio anterior)

Realizar un constructor capaz de poder instanciar objetos pasándole como parámetros:

i. La razón social.
ii. La razón social, y el precio por hora.

Realizar un método de instancia llamado “MostrarGarage”, que no recibirá parámetros y
que mostrará todos los atributos del objeto.
Crear el método de instancia “Equals” que permita comparar al objeto de tipo Garaje con un
objeto de tipo Auto. Sólo devolverá TRUE si el auto está en el garaje.
Crear el método de instancia “Add” para que permita sumar un objeto “Auto” al “Garage”
(sólo si el auto no está en el garaje, de lo contrario informarlo).
Ejemplo: $miGarage->Add($autoUno);
Crear el método de instancia “Remove” para que permita quitar un objeto “Auto” del
“Garage” (sólo si el auto está en el garaje, de lo contrario informarlo).
Ejemplo: $miGarage->Remove($autoUno);
En testGarage.php, crear autos y un garage. Probar el buen funcionamiento de todos los
métodos.

LEANDRO NOGUERA*/

include_once "garage.php";

$g1 = new Garage("El Garage", 105.30);

$a1 = new Auto("Renault", "Azul");
$a2 = new Auto("Renault", "Rojo");

$a3 = new Auto("Fiat", "Azul", 60450.78);
$a4 = new Auto("Fiat", "Azul", 54567.82);

$a5 = new Auto("Ford", "Rojo", 65423.42, new DateTime("2021-3-15"));

echo $g1->Add($a1);
echo "<br/>";

echo $g1->Add($a2);
echo "<br/>";

echo $g1->Add($a3);
echo "<br/>";

echo $g1->Add($a4);
echo "<br/>";

echo $g1->Add($a5);
echo "<br/>";

echo $g1->Remove($a1);
echo "<br/>";

echo $g1->Remove($a1);
echo "<br/>";


 ?>