<?php

    //carga de archivos
    var_dump($_FILES);

    //$destino = "uploads/".$_FILES["archivo"]["name"];
    //move_uploaded_file($_FILES["archivo"]["tmp_name"], $destino);

    $dir_subida = 'archivos-subidos/';

    if (!file_exists($dir_subida)) {
        mkdir('archivos-subidos/', 0777, true);

    }

    $extension = explode(".", $_FILES["archivo"]["name"]);

    $fecha = date_create("now");
    $destino = $dir_subida . $_POST["nombre"] . date_format($fecha, "dmY") . "." . $extension[1];
    move_uploaded_file($_FILES["archivo"]["tmp_name"], $destino);
?>