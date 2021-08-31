<?php
require_once "usuario.php";
require_once "funciones.php";

$u1 = new Usuario();
$u1->nombre = "Leandro";

MostrarUsuario($u1);


?>