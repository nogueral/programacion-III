<?php
include "./clases/usuario.php";
/*
Aplicación No 32(Modificacion BD)
Archivo: ModificacionUsuario.php
método:POST
Recibe los datos del usuario(nombre, clavenueva, clavevieja,mail )por POST ,
crear un objeto y utilizar sus métodos para poder hacer la modificación,
guardando los datos la base de datos
retorna si se pudo agregar o no.
Solo pueden cambiar la clave

LEANDRO NOGUERA
*/

if(isset($_POST["nombre"]) && isset($_POST["claveNueva"]) && isset($_POST["mail"]) && isset($_POST["claveVieja"]) && isset($_GET["archivo"]) && $_GET["archivo"] == "modificacionUsuario.php")
{
    $user = Usuario::CrearObjeto($_POST["nombre"], "empty", $_POST["claveVieja"], $_POST["mail"]);
    
    $filas = $user->ModificarUsuario($_POST["claveNueva"]);

    if($filas != 0)
    {
        echo "Datos modificados correctamente";
        
    } else{

        echo "Error al intentar procesar el archivo";
        
    }

} else{
    
    echo "Error en la carga de parametros";
}

?>