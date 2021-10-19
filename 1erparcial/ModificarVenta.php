<?php
include "./clases/VentaPizza.php";
/*
6- (2 pts.) ModificarVenta.php(por PUT), debe recibir el número de pedido, el email del usuario, el sabor,tipo y
cantidad, si existe se modifica , de lo contrario informar.
*/
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"),$put_vars);

   $retorno = VentaPizza::ModificarVentaParametros($put_vars["usuario"], $put_vars["sabor"], $put_vars["tipo"], $put_vars["cantidad"], $put_vars["nroPedido"]);

    if($retorno != 0){

        echo "Modificado con exito";
    
    } else{
    
        echo "Nro de pedido intexistente";    
    }


} else {

    echo "Error en los parametros ingresados";
}


?>