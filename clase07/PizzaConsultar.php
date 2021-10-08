<?php

include "./clases/Pizza.php";
/*
2-
(1pt.) PizzaConsultar.php: (por POST)Se ingresa Sabor,Tipo, si coincide con algún registro del archivo Pizza.json,
retornar “Si Hay”. De lo contrario informar si no existe el tipo o el sabor.
*/

if(isset($_GET['sabor']) &&isset($_GET['tipo']))
{
    $p1 = Pizza::CrearObjeto($_GET['sabor'], 0, $_GET['tipo'], 0);

    $retorno = Pizza::VerificarPizza($p1);
    
    echo $retorno;

} else {

    echo "No se pudo guardar";
}


?>