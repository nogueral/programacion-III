<?php
/*
Aplicación No 10 (Arrays de Arrays)
Realizar las líneas de código necesarias para generar un Array asociativo y otro indexado que
contengan como elementos tres Arrays del punto anterior cada uno. Crear, cargar y mostrar los
Arrays de Arrays.

NOGUERA LEANDRO
*/

$lapicera1 = array("color"=>"rojo", "marca"=>"bic", "trazo"=>"grueso", "precio"=>40.57);
$lapicera2 = array("color"=>"negro", "marca"=>"faber", "trazo"=>"fino", "precio"=>23.82);
$lapicera3 = array("color"=>"azul", "marca"=>"pepito", "trazo"=>"grueso", "precio"=>70.23);
$vec = array();

array_push($vec, $lapicera1, $lapicera2, $lapicera3);

for ($i=0; $i < count($vec); $i++) { 
	
	echo "<br/><br/>Se imprime lapicera en posicion: ", $i;

	foreach ($vec[$i] as $key => $value) {
	
	print("<br/> Clave: $key - Valor: $value");
	
	}
}

?>