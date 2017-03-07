<?php
class Usuario {
	private $id, $usuario, $clave, $nombre, $tipo, $poblacion, $direccion;
	
	public function __construct($id, $usuario, $clave, $nombre, $tipo, $poblacion, $direccion) {
		$this->id = $id;
		$this->usuario = $usuario;
		$this->clave = $clave;
		$this->nombre = $nombre;
		$this->tipo = $tipo;
		$this->poblacion = $poblacion;
		$this->direccion = $direccion;
	}
	
	public function __get($atributo) {
		switch ($atributo) {
			case 'id':
				return $this->id;
				break;
				
			case 'usuario':
				return $this->usuario;
				break;
				
			case 'clave':
				return $this->clave;
				break;
				
			case 'nombre':
				return $this->nombre;
				break;
				
			case 'tipo':
				return $this->tipo;
				break;
				
			case 'poblacion':
				return $this->poblacion;
				break;
				
			case 'direccion':
				return $this->direccion;
				break;
				
			default:
				return null;
				break;
		}
	}
	
	public function __set($atributo, $valor) {
		switch ($atributo) {
			case 'usuario':
				$this->usuario = $valor;
				break;
				
			case 'clave':
				$this->clave = $valor;
				break;
				
			case 'nombre':
				$this->nombre = $valor;
				break;
				
			case 'tipo':
				$this->tipo = $valor;
				break;
				
			case 'poblacion':
				$this->poblacion = $valor;
				break;
				
			case 'direccion':
				$this->direccion = $valor; 
				break;
				
			default:
				return null;
				break;
		}
	}
	
	public function __toString() {
		return $this->id . " " . $this->usuario . " " . $this->nombre;
	}
	
	public function getTypeString($typeID) {
		switch($typeID) {
			case 1:
				return "Administrador";
				break;
				
			case 2:
				return "Cliente";
				break;
				
			case 3:
				return "Repartidor";
				break;
				
			default:
				return "Desconocido";
				break;
		}
	}
	
	
}

?>