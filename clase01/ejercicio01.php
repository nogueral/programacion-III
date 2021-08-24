<?php
/*Aplicación No 1 (Sumar números)
Confeccionar un programa que sume todos los números enteros desde 1 mientras la suma no
supere a 1000. Mostrar los números sumados y al finalizar el proceso indicar cuantos números
se sumaron.

NOGUERA LEANDRO
*/

$contador = 0;
$suma = 1;

do{
    echo $suma . " - ";
    $suma += $suma;
    $contador++;

}while($suma < 1000);


echo "<br/> Cantidad de nros sumados: ", $contador;


?>