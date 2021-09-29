<?php
include "./clases/producto.php";
/* 
Aplicación No 30 ( AltaProducto BD)
Archivo: altaProducto.php
método:POST
Recibe los datos del producto(código de barra (6 sifras ),nombre ,tipo, stock, precio )por POST
, carga la fecha de creación y crear un objeto ,se debe utilizar sus métodos para poder
verificar si es un producto existente,
si ya existe el producto se le suma el stock , de lo contrario se agrega .
Retorna un :
“Ingresado” si es un producto nuevo
“Actualizado” si ya existía y se actualiza el stock.
“no se pudo hacer“si no se pudo hacer
Hacer los métodos necesarios en la clase

LEANDRO NOGUERA
*/

if(isset($_POST['codigoBarra']) && isset($_POST['nombre']) && isset($_POST['tipo']) && isset($_POST['stock']) && isset($_POST['precio']))
{
    $prod = Producto::CrearObjeto($_POST['codigoBarra'],$_POST['nombre'],$_POST['tipo'],$_POST['stock'],$_POST['precio']);

    switch ($prod->GuardarProductoBD()) {
        case 0:
            echo "Actualizado";
            break;
        case 1:
            echo "Ingresado";
            break;
        default:
            echo "No se pudo hacer";
            break;
    }


} else {

    echo "Error en los parametros ingresados";
}

?>