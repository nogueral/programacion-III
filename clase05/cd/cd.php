<?php

require_once "AccesoDatos.php";

class Cd
{
    public $id;
    public $titulo;
    public $cantante;
    public $año;

    public function __construct()
    {

    }

    public static function ConstructorParametrizado($id,$titulo,$cantante,$año)
    {
        $cd = new Cd();

        $cd->id = $id;
        $cd->titulo = $titulo;
        $cd->cantante = $cantante;
        $cd->año = $año;

        return $cd;
    }

    public static function TraerTodosLosCds()
    {
        $accesoBD = AccesoDatos::dameUnObjetoAcceso();

        $query = "select id,titel as titulo, interpret as cantante,jahr as año from cds";

        $data = $accesoBD->RetornarConsulta($query);

        $data->execute();

        return $data->fetchAll(PDO::FETCH_CLASS, "cd");
    }

}

?>