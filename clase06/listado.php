<?php

include "./clases/usuario.php";
include "./clases/producto.php";
include "./clases/venta.php";
/* 
Aplicación No 28 ( Listado BD)
Archivo: listado.php
método:GET
Recibe qué listado va a retornar(ej:usuarios,productos,ventas)
cada objeto o clase tendrán los métodos para responder a la petición
devolviendo un listado <ul> o tabla de html <table>
*/

if(isset($_GET["listado"]) && isset($_GET["listado"]) && $_GET["archivo"] == "listado.php")
{
    switch ($_GET["listado"])
    {
        case 'usuarios':
            Usuario::ArmarListaBD();
            break;
        case 'productos':
            Producto::ArmarLista();
            break;
        case 'ventas':
            Venta::ArmarLista();
            break;
        default:
            echo "Listado inexistente";
            break;
    }

} else {

    echo "Error en los parametros ingresados";
}

?>