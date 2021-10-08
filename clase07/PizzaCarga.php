<?php

include "./clases/Pizza.php";
/*
5- (2 pts.)PizzaCarga.php:.(continuación) Cambio de get a post.
completar el alta con imagen de la pizza, guardando la imagen con el tipo y el sabor como nombre en la carpeta
/ImagenesDePizzas.
*/

if(isset($_POST['sabor']) && isset($_POST['precio']) && isset($_POST['tipo']) && isset($_POST['cantidad']))
{
    $p1 = Pizza::CrearObjeto($_POST['sabor'], $_POST['precio'], $_POST['tipo'], $_POST['cantidad']);

    if(Pizza::ValidarProducto($p1))
    {
        echo "Ingresado";

    } else {

        echo "Actualizado";
    }

} else {

    echo "No se pudo guardar";
}


?>