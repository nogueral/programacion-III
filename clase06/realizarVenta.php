<?php
include "./clases/usuario.php";
include "./clases/producto.php";
include "./clases/venta.php";
/*
Aplicación No 31 (RealizarVenta BD )
Archivo: RealizarVenta.php
método:POST
Recibe los datos del producto(código de barra), del usuario (el id )y la cantidad de ítems ,por
POST .
Verificar que el usuario y el producto exista y tenga stock.
Retorna un :
“venta realizada”Se hizo una venta
“no se pudo hacer“si no se pudo hacer
Hacer los métodos necesarios en las clases

LEANDRO NOGUERA
*/

if(isset($_POST['codigoBarra']) && isset($_POST['id']) && isset($_POST['cantidad']) && isset($_GET["archivo"]) && $_GET["archivo"] == "realizarVenta.php")
{

    $auxProd = Producto::TraerUnProducto($_POST['codigoBarra']);
    $auxUser = Usuario::TraerUnUsuario($_POST['id']);


    if($auxProd != false && $auxUser != false)
    {
        if($auxProd->ValidarStock($_POST['cantidad']))
        {
            $venta = Venta::CrearVenta($_POST['id'], $_POST['cantidad'], $_POST['codigoBarra'], $auxProd->GetId());
            $id = $venta->GuardarVentaBD();
            echo "Venta realizada. ID: $id";

        } else{

            echo "No hay stock suficiente";
        }
        
    } else{

        echo "Verificar usuario y/o producto";
    }

} else {

    echo "Error en los parametros ingresados";
}

?>