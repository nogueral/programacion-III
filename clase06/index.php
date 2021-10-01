<?php

    if(isset($_GET['archivo']))
    {
        switch ($_GET['archivo']) {
            case 'registro.php':
                include "registro.php";
                break;
            case 'listado.php':
                include "listado.php";
                break;
            case 'login.php':
                include "login.php";
                break;
            case 'altaProducto.php':
                include "altaProducto.php";
                break;
            case 'realizarVenta.php':
                include "realizarVenta.php";
                break;
            case 'modificacionUsuario.php':
                include "modificacionUsuario.php";
                break;
            case 'modificacionProducto.php':
                include "modificacionProducto.php";
                break;
            default:
                echo "No existe listado";
                break;
        }   

    } else{
        echo "Error en los datos";
    }
?>