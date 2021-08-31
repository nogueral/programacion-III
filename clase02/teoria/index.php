<?php
require "usuario.php";
require "funciones.php";
include "inicio.php";

$u1 = new Usuario();
$u1->nombre = "Leandro";

Saludar($u1->nombre);



?>