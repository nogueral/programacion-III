<?php
include "usuario.php";
/*
Aplicación No 24 ( Listado JSON y array de usuarios)
Archivo: listado.php
método:GET
Recibe qué listado va a retornar(ej:usuarios,productos,vehículos,...etc),por ahora solo tenemos
usuarios).
En el caso de usuarios carga los datos del archivo usuarios.json.
se deben cargar los datos en un array de usuarios.
Retorna los datos que contiene ese array en una lista
<ul>
<li>apellido, nombre,foto</li>
<li>apellido, nombre,foto</li>
</ul>
Hacer los métodos necesarios en la clase usuario

LEANDRO NOGUERA
*/

if(isset($_GET["listado"]))
{
    switch ($_GET["listado"])
    {
        case 'usuarios':
            Usuario::ArmarLista('usuarios.json');
            break;
        
        default:
            echo "Listado inexistente";
            break;
    }

} else {

    echo "Error en los parametros ingresados";
}

?>