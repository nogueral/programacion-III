<?php

include "./clases/Pizza.php";
include "./clases/VentaPizza.php";
include "./clases/Cupon.php";
/*
3-
a- (1 pts.) AltaVenta.php: (por POST)se recibe el email del usuario y el sabor,tipo y cantidad ,si el ítem existe en
Pizza.json, y hay stock guardar en la base de datos( con la fecha, número de pedido y id autoincremental ) y se
debe descontar la cantidad vendida del stock .
*/

if(isset($_POST['mail']) && isset($_POST['sabor']) && isset($_POST['tipo']) && isset($_POST['cantidad']) && isset($_POST['monto']) && isset($_POST['cupon']))
{
    $p1 = VentaPizza::CrearObjeto($_POST['sabor'], $_POST['monto'], $_POST['tipo'], $_POST['cantidad'], $_POST['mail']);
    
    if(Cupon::UsarCupon($_POST['cupon'], $_POST['monto'])){

        echo "Se utilizo cupon de descuento <br>";
    }

    if(VentaPizza::CrearVenta($p1, $_POST['mail']))
    {
        echo "Se cargo producto";
    } else {
        echo "Error en la carga";
    }
} else{

    echo "Error en los datos";
}

?>