<?php
include "producto.php";
include "usuario.php";
include "venta.php";
/*
Aplicación No 26 (RealizarVenta)
Archivo: RealizarVenta.php
método:POST
Recibe los datos del producto(código de barra), del usuario (el id )y la cantidad de ítems ,por
POST .
Verificar que el usuario y el producto exista y tenga stock.
crea un ID autoincremental(emulado, puede ser un random de 1 a 10.000).
carga los datos necesarios para guardar la venta en un nuevo renglón.
Retorna un :
“venta realizada”Se hizo una venta
“no se pudo hacer“si no se pudo hacer
Hacer los métodos necesarios en las clases
*/

if(isset($_POST['codigoBarra']) && isset($_POST['id']) && isset($_POST['cantidad']))
{

    $auxProd = Producto::ConstructorParametrizado($_POST['codigoBarra']);
    $auxUser = Usuario::ConstructorPorID($_POST['id']);


    if(Usuario::UsuarioExistente($auxUser) && Producto::ProductoExistente($auxProd, $_POST['cantidad']))
    {
        if(Venta::GuardarVenta(new Venta($_POST['id'], $_POST['cantidad'], $_POST['codigoBarra'])))
        {
            Producto::ModificarStock($auxProd, $_POST['cantidad']);
            echo "Venta realizada";

        } 
        
    } else{

        echo "No se pudo hacer";
    }

} else {

    echo "Error en los parametros ingresados";
}

?>