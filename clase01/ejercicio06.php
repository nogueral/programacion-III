<?php
/*
Aplicación No 6 (Carga aleatoria)
Definir un Array de 5 elementos enteros y asignar a cada uno de ellos un número (utilizar la
función rand). Mediante una estructura condicional, determinar si el promedio de los números
son mayores, menores o iguales que 6. Mostrar un mensaje por pantalla informando el
resultado.

NOGUERA LEANDRO
*/

$vec = array(rand(1,12), rand(1,12), rand(1,12), rand(1,12), rand(1,12));

var_dump($vec);
echo "<br>";

$prom = array_sum($vec)/count($vec);

if($prom > 6){

    echo "El promedio es mayor a 6";

} else if($prom < 6){

    echo "El promedio es menor a 6";

} else {

    echo "El promedio es 6";
}

?>