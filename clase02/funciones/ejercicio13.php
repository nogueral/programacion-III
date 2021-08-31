<?php

/*Aplicación No 13 (Invertir palabra)
Crear una función que reciba como parámetro un string ($palabra) y un entero ($max). La
función validará que la cantidad de caracteres que tiene $palabra no supere a $max y además
deberá determinar si ese valor se encuentra dentro del siguiente listado de palabras válidas:
“Recuperatorio”, “Parcial” y “Programacion”. Los valores de retorno serán:
1 si la palabra pertenece a algún elemento del listado.
0 en caso contrario.

LEANDRO NOGUERA*/

function ValidarPalabra($palabra, $max){

    $retorno = 0;

    $palabra = strtolower($palabra);
    $palabra = ucfirst($palabra);

    if(strlen($palabra) <= $max)
    {
        if(strcmp($palabra, "Recuperatorio")==0 || strcmp($palabra, "Parcial")==0 || strcmp($palabra, "Programacion")==0)
        {
            $retorno = 1;
        }
    }



    return $retorno;
}

?>