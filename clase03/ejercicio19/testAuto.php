<?php
include "auto.php";

// $a1 = new Auto("Renault", "Azul");
// $a2 = new Auto("Renault", "Rojo");

// $a3 = new Auto("Ford", "Azul", 88500);
// $a4 = new Auto("Ford", "Azul", 74600);

// $a5 = new Auto("Fiat", "Negro", 55400, new DateTime("2020-01-01"));

// echo $a3->AgregarImpuestos(1500) . "<br>";
// echo $a4->AgregarImpuestos(1500) . "<br>";
// echo $a5->AgregarImpuestos(1500) . "<br>";

// $sumarAutos = Auto::Add($a1, $a2);
// echo "La suma de los dos primeros autos es: " . $sumarAutos . "<br>";

// echo "Comparacion 1er auto con 2do: " . $a1->Equals($a2) . "<br>";
// echo "Comparacion 1er auto con 5to: " . $a1->Equals($a5) . "<br>";

// Auto::MostrarAuto($a1);
// echo "<br>";
// Auto::MostrarAuto($a3);
// echo "<br>";
// Auto::MostrarAuto($a5);

// Auto::GuardarAuto($a1);
// Auto::GuardarAuto($a2);
// Auto::GuardarAuto($a3);
// Auto::GuardarAuto($a4);
// Auto::GuardarAuto($a5);

var_dump(Auto::LeerAuto());

?>