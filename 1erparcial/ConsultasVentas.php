<?php

include "./clases/VentaPizza.php";
/*
4- (3 pts.)ConsultasVentas.php: necesito saber :
a- la cantidad de pizzas vendidas
b- el listado de ventas entre dos fechas ordenado por sabor.
c- el listado de ventas de un usuario ingresado
d- el listado de ventas de un sabor ingresado
*/
echo "a- la cantidad de pizzas vendidas en un día en particular, si no se pasa fecha, se muestran las del dia de hoy <br>";
if(isset($_GET['fecha']))
{
    var_dump(VentaPizza::CantidadTotal($_GET['fecha']));
} else{
    $fecha = new DateTime('now');
    var_dump(VentaPizza::CantidadTotal($fecha->format('Y-m-d')));
}

echo "<br>b- el listado de ventas entre dos fechas ordenado por sabor. <br>";
var_dump(VentaPizza::VentasEntreDosFechas($_GET['fechaUno'], $_GET['fechaDos']));
echo "<br>c- el listado de ventas de un usuario ingresado <br>";
var_dump(VentaPizza::VentasPorUsuario($_GET['user']));
echo "<br>d- el listado de ventas de un sabor ingresado <br>";
var_dump(VentaPizza::VentasPorSabor($_GET['sabor']));

?>