<?php
/*
Aplicación No 5 (Números en letras)
Realizar un programa que en base al valor numérico de una variable $num, pueda mostrarse
por pantalla, el nombre del número que tenga dentro escrito con palabras, para los números
entre el 20 y el 60.
Por ejemplo, si $num = 43 debe mostrarse por pantalla “cuarenta y tres”.

NOGUERA LEANDRO
*/

$num = random_int(20, 30);

echo "El numero asignado es: ", $num;

switch (substr($num, 0, 1)) {
	case "2":
		if(substr($num, 1) == 0){
			printf("<br/> Veinte");
		} else {
			printf("<br/> Veinti");
		}
		break;
	case "3":
		if(substr($num, 1) == 0){
			printf("<br/> Treinta");
		} else {
			printf("<br/> Treinta y ");
		}
		break;
	case "4":
		if(substr($num, 1) == 0){
			printf("<br/> Cuarenta");
		} else {
			printf("<br/> Cuarenta y ");
		}
		break;
	case "5":
		if(substr($num, 1) == 0){
			printf("<br/> Cincuenta");
		} else {
			printf("<br/> Cincuenta y ");
		}
		break;
	default:
		if(substr($num, 1) == 0){
			printf("<br/> Sesenta");
		} else {
			printf("<br/> Sesenta y ");
		}
		break;
}

switch (substr($num, 1)) {
	case "1":
		printf("uno");
		break;
	case "2":
		printf("dos");
		break;
	case "3":
		printf("tres");
		break;
	case "4":
		printf("cuatro");
		break;
	case "5":
		printf("cinco");
		break;
	case "6":
		printf("seis");
		break;
	case "7":
		printf("siete");
		break;
	case "8":
		printf("ocho");
		break;
	case "9":
		printf("nueve");
		break;
	default:
		break;
}
?>