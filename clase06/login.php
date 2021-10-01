<?php

include "./clases/usuario.php";

/* 
Aplicación No 29( Login con bd)
Archivo: Login.php
método:POST
Recibe los datos del usuario(clave,mail )por POST ,
crear un objeto y utilizar sus métodos para poder verificar si es un usuario registrado en la
base de datos,
Retorna un :
“Verificado” si el usuario existe y coincide la clave también.
“Error en los datos” si esta mal la clave.
“Usuario no registrado si no coincide el mail“
Hacer los métodos necesarios en la clase usuario.

LEANDRO NOGUERA
*/

if(isset($_POST["clave"]) && isset($_POST["mail"]) && isset($_GET["archivo"]) && $_GET["archivo"] == "login.php")
{
    $user = Usuario::CrearObjeto("empty", "empty", $_POST["clave"], $_POST["mail"]);

    $data = Usuario::ValidarUsuarioBD($user);

    switch ($data) {
        case 0:
            echo "Error en los datos";
        break;
        case 1:
            echo "Verificado";
        break;
        default:
            echo "Usuario no registrado";
         break;
    }

} else {

    echo "Error en los parametros ingresados";
}

?>