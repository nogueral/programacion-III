<?php

include "./clases/Pizza.php";
/*
3-
a- (1 pts.) AltaVenta.php: (por POST)se recibe el email del usuario y el sabor,tipo y cantidad ,si el ítem existe en
Pizza.json, y hay stock guardar en la base de datos( con la fecha, número de pedido y id autoincremental ) y se
debe descontar la cantidad vendida del stock .
*/

if(isset($_POST['mail']) && isset($_POST['sabor']) && isset($_POST['tipo']) && isset($_POST['cantidad']))
{
    $p1 = Pizza::CrearObjeto($_POST['sabor'], 0, $_POST['tipo'], $_POST['cantidad']);

    if(Pizza::CrearVenta($p1, $_POST['mail']))
    {
        echo "Se cargo producto";
    } else {
        echo "Error en la carga";
    }
} else{

    echo "Error en los datos";
}

?>