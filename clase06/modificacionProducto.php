<?php
include "./clases/producto.php";
/*
Aplicación No 33 ( ModificacionProducto BD)
Archivo: modificacionproducto.php
método:POST
Recibe los datos del producto(código de barra (6 sifras ),nombre ,tipo, stock, precio )por POST
,
crear un objeto y utilizar sus métodos para poder verificar si es un producto existente,
si ya existe el producto el stock se sobrescribe y se cambian todos los datos excepto:
el código de barras .
Retorna un :
“Actualizado” si ya existía y se actualiza
“no se pudo hacer“si no se pudo hacer
Hacer los métodos necesarios en la clase

LEANDRO NOGUERA
*/

if(isset($_POST["codigo_de_barra"]) && isset($_POST["nombre"]) && isset($_POST["tipo"]) && isset($_POST["stock"]) && isset($_POST["precio"]) && isset($_GET["archivo"]) && $_GET["archivo"] == "modificacionProducto.php")
{
    $prod = Producto::CrearObjeto($_POST["codigo_de_barra"], $_POST["nombre"], $_POST["tipo"], $_POST["stock"], $_POST["precio"]);
    
    $filas = $prod->ModificarProducto();

    if($filas != 0)
    {
        echo "Actualizado";
        
    } else{

        echo "No se pudo hacer";
        
    }

} else{
    
    echo "Error en la carga de parametros";
}

?>