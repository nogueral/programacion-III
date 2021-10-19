<?php

include "./clases/Pizza.php";
/*
B- (1 pt.) PizzaCarga.php: (por POST)se ingresa Sabor, precio, Tipo (“molde” o “piedra”), cantidad( de unidades).
Se guardan los datos en en el archivo de texto Pizza.json, tomando un id autoincremental como
identificador(emulado) .Sí el sabor y tipo ya existen , se actualiza el precio y se suma al stock existente.
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