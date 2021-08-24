<?php
/*
Aplicación No 7 (Mostrar impares)
Generar una aplicación que permita cargar los primeros 10 números impares en un Array.
Luego imprimir (utilizando la estructura for) cada uno en una línea distinta (recordar que el
salto de línea en HTML es la etiqueta <br/>). Repetir la impresión de los números utilizando
las estructuras while y foreach.

NOGUERA LEANDRO
*/

$vec = array();

do{

    $num = rand(1, 100);

    if($num % 2 != 0)
    array_push($vec, $num);

}while(count($vec) < 10);

echo "Imprimo con for" . "<br/>";

for ($i=0; $i < count($vec); $i++) { 
    
    echo $vec[$i] . "<br/>";
}

echo "Imprimo con while" . "<br/>";

$contador = 0;

do{
    echo $vec[$contador] . "<br/>";
    $contador++;

}while($contador < count($vec));

echo "Imprimo con foreach" . "<br/>";

foreach ($vec as $value) {
    
    echo $value . "<br/>";
}

?>