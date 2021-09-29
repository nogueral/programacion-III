<?php

include "./clases/usuario.php";
/*
Aplicación No 27 (Registro BD)
Archivo: registro.php
método:POST
Recibe los datos del usuario( nombre,apellido, clave,mail,localidad )por POST ,
crear un objeto con la fecha de registro y utilizar sus métodos para poder hacer el alta,
guardando los datos la base de datos
retorna si se pudo agregar o no.
*/

if(isset($_POST["nombre"]) && isset($_POST["clave"]) && isset($_POST["mail"]) && isset($_POST["apellido"]) && isset($_POST["localidad"]))
{
    $user = Usuario::CrearObjeto($_POST["nombre"], $_POST["apellido"], $_POST["clave"], $_POST["mail"], $_POST["localidad"]);
    
    $filas = $user->GuardarUsuarioBD();

    if($filas != 0)
    {
        echo "Datos cargardos correctamente";
        
    } else{

        echo "Error al intentar procesar el archivo";
        
    }

} else{
    
    echo "Error en la carga de parametros";
}




?>