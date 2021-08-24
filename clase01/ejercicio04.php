<?php
/*
Aplicación No 4 (Calculadora)
Escribir un programa que use la variable $operador que pueda almacenar los símbolos
matemáticos: ‘+’, ‘-’, ‘/’ y ‘*’; y definir dos variables enteras $op1 y $op2. De acuerdo al
símbolo que tenga la variable $operador, deberá realizarse la operación indicada y mostrarse el
resultado por pantalla.

NOGUERA LEANDRO
*/

$operador = random_int(0, 3);;
$op1 = random_int(1, 100);
$op2 = random_int(1, 100);

switch ($operador) {
	case 0:
		echo "La suma es: ", $op2+$op2;
		break;
	case 1:
		echo "La resta es: ", $op1-$op2;
		break;
	case 2:
		echo "La multiplicacion es: ", $op1*$op2;
		break;
	default:
		if($op2==0)
		{
			echo "No se puede dividir por 0";
		} else 
		{
			echo "La division es: ", $op1/$op2;
		}
		break;
}
?>