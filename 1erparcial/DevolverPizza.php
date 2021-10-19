<?php

include "./clases/VentaPizza.php";
include "./clases/Cupon.php";
/*
7- (2 pts.)DevolverPizza.php Guardar en el archivo (devoluciones.json y cupones.json):
a-Se ingresa el número de pedido y la causa de la devolución. El número de pedido debe existir, se ingresa una
foto del cliente enojado,esto debe generar un cupón de descuento con el 10% de descuento para la próxima
compra.
*/

if(isset($_POST['nroPedido']) && isset($_POST['causa'])){

    $venta = VentaPizza::TraerUnaVenta($_POST["nroPedido"]);

    if($venta != false)
    {
        $cupon = Cupon::CrearObjeto("10%", $_POST['causa']);
        Cupon::GuardarCupon($cupon);
        VentaPizza::GuardarDevolucion($venta);
        VentaPizza::GuardarImagen($venta);
        echo "Se ha generado el cupon de devolucion";
        
    }

} else {
    echo "Verifique parametros";
}
?>