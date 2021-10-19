<?php
/*
LEANDRO NOGUERA
6- (1 pts.) borrarVenta.php(por DELETE), debe recibir un número de pedido,se borra la venta y la foto se mueve a
la carpeta /BACKUPVENTAS.*/

include "./clases/VentaPizza.php";


if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"),$put_vars);

    $retorno = VentaPizza::TraerUnaVenta($put_vars["nroPedido"]);
    

    if($retorno != false)
    {

        

        if(VentaPizza::BorrarVenta($put_vars["nroPedido"]) > 0)
        {
            echo VentaPizza::MoverDirectorioFotografia($retorno->ruta);
            echo "<br>Se ha borrado la venta <br>";
            
        }
        
    }




} else {

    echo "Error en los parametros ingresados";
}


?>