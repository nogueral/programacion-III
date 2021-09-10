<?php
include "usuario.php";
/*
    Aplicación No 22 ( Login)
Archivo: Login.php
método:POST
Recibe los datos del usuario(clave,mail )por POST ,
crear un objeto y utilizar sus métodos para poder verificar si es un usuario registrado,
Retorna un :
“Verificado” si el usuario existe y coincide la clave también.
“Error en los datos” si esta mal la clave.
“Usuario no registrado si no coincide el mail“
Hacer los métodos necesarios en la clase usuario
*/

if(isset($_POST["clave"]) && isset($_POST["mail"]))
{
    $user = Usuario::ConstructorParametrizado($_POST["clave"], $_POST["mail"]);

    $data = Usuario::ValidarUsuario($user);

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