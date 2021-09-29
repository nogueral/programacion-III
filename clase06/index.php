<?php

    if(isset($_GET['archivo']))
    {
        switch ($_GET['archivo']) {
            case 'registro.php':
                header('Location: http://localhost/Noguera/clase06/registro.php');
                break;
            
            default:
                # code...
                break;
        }   

    }
?>