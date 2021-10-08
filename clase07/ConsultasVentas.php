<?php

include "./clases/Pizza.php";
/*
4- (3 pts.)ConsultasVentas.php: necesito saber :
a- la cantidad de pizzas vendidas
b- el listado de ventas entre dos fechas ordenado por sabor.
c- el listado de ventas de un usuario ingresado
d- el listado de ventas de un sabor ingresado
*/
echo "a- la cantidad de pizzas vendidas <br>";
var_dump(Pizza::CantidadTotal());
echo "<br>b- el listado de ventas entre dos fechas ordenado por sabor. <br>";
var_dump(Pizza::VentasEntreDosFechas("2021-06-18", "2021-11-01"));
echo "<br>c- el listado de ventas de un usuario ingresado <br>";
var_dump(Pizza::VentasPorUsuario("leandro@leandro.com"));
echo "<br>d- el listado de ventas de un sabor ingresado <br>";
var_dump(Pizza::VentasPorSabor("muzzarella"));

?>