<?php

/*A- (1 pt.) index.php:Recibe todas las peticiones que realiza el postman, y administra a que archivo se debe incluir. */
    if(isset($_GET['archivo']))
    {
        switch ($_GET['archivo']) {
            case 'PizzaCarga.php':
                include "PizzaCarga.php";
                break;
            case 'PizzaConsultar.php':
                include "PizzaConsultar.php";
                break;
            case 'AltaVenta.php':
                include "AltaVenta.php";
                break;
            case 'ConsultasVentas.php':
                include "ConsultasVentas.php";
                break;
            case 'ModificarVenta.php':
                include "ModificarVenta.php";
                 break;
            case 'BorrarVenta.php':
                include "BorrarVenta.php";
                break;
            case 'DevolverPizza.php':
                include "DevolverPizza.php";
                break;
            default:
                echo "No existe listado";
                break;
        }   

    } else{
        echo "Error en los datos";
    }
?>