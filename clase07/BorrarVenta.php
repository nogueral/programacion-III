<?php
/*
LEANDRO NOGUERA
7- (2 pts.) borrarVenta.php(por DELETE), debe recibir un número de pedido,se borra la venta y la foto se mueve a
la carpeta /BACKUPVENTAS*/

include "./clases/Pizza.php";


if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"),$put_vars);

    $retorno = Pizza::TraerUnaVenta($put_vars["nroPedido"]);

    if($retorno != false)
    {
        if(Pizza::BorrarVenta($put_vars["nroPedido"]) > 0)
        {
            echo "Se ha borrado la venta <br>";
            echo Pizza::MoverDirectorioFotografia($retorno->ruta);
        }
        
    }




} else {

    echo "Error en los parametros ingresados";
}


?>