<?php

include_once "auto.php";

class Garage
{
    public $_razonSocial;
    public $_precioPorHora;
    public $_autos;

    public function __construct($_razonSocial, $_precioPorHora = 0){

        $this->_razonSocial = $_razonSocial;
        $this->_precioPorHora = $_precioPorHora;
        $this->_autos = array();
    }

    public function MostrarGarage(){

        echo "Razon Social: " .  $this->_razonSocial . "<br>";
        echo "Precio por hora: " .  $this->_precioPorHora . "<br>";
        echo "Listado de vehiculos: <br>";
        foreach ($this->_autos as $auto) {
            Auto::MostrarAuto($auto);
        }
    }

    public function Equals($a1){

        foreach ($this->_autos as $auto) {
            
            if($auto->Equals($a1))
            return true;
        }

        return false;
    }

    public function Add($a1){

        if(!$this->Equals($a1)){

            array_push($this->_autos, $a1);
            return true;

        } else{

            echo "No se puede agregar elemento porque ya existe en la lista <br>";
            return false;
        }
    }

    public function Remove($a1){

        for ($i=0; $i < count($this->_autos); $i++) 
		{ 
			if($this->_autos[$i]->Equals($a1))
			{
				unset($this->_autos[$i]);
				$this->_autos = array_values($this->_autos);
				return "Vehiculo eliminado";

			} else {
				return "El vehiculo no existe en la lista";
			}
		}
    }
}


?>