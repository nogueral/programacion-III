<?php
/*
Aplicación No 9 (Arrays asociativos)
Realizar las líneas de código necesarias para generar un Array asociativo $lapicera, que
contenga como elementos: ‘color’, ‘marca’, ‘trazo’ y ‘precio’. Crear, cargar y mostrar tres
lapiceras.

NOGUERA LEANDRO
*/

$lapicera1 = array("color"=>"rojo", "marca"=>"bic", "trazo"=>"grueso", "precio"=>40.57);
$lapicera2 = array("color"=>"negro", "marca"=>"faber", "trazo"=>"fino", "precio"=>23.82);
$lapicera3 = array("color"=>"azul", "marca"=>"pepito", "trazo"=>"grueso", "precio"=>70.23);

	printf("Lapicera nro 1: <br/>");
	foreach ($lapicera1 as $key => $value) {
	
	print("<br/> Clave: $key - Valor: $value");
	
	}

	printf("<br/><br/>Lapicera nro 2: <br/>");
	foreach ($lapicera2 as $key => $value) {
	
	print("<br/> Clave: $key - Valor: $value");
	
	}

	printf("<br/><br/>Lapicera nro 3: <br/>");
	foreach ($lapicera3 as $key => $value) {
	
	print("<br/> Clave: $key - Valor: $value");
	
	}


?>