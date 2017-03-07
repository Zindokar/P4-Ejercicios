<?php

class Bebida {
    private $id, $marca, $stock, $pvp;

    public function __construct($id, $marca, $stock, $pvp) {
        $this->id = $id;
        $this->marca = $marca;
        $this->stock = $stock;
        $this->pvp = $pvp;
    }

    public function __get($atributo) {
        switch ($atributo) {
            case 'id':
                return $this->id;
                break;

            case 'marca':
                return $this->marca;
                break;

            case 'stock':
                return $this->stock;
                break;

            case 'pvp':
                return $this->pvp;
                break;

            default:
                return null;
                break;
        }
    }

    public function __set($atributo, $valor) {
        switch ($atributo) {
            case 'marca':
                $this->marca = $valor;
                break;

            case 'stock':
                $this->stock = $valor;
                break;

            case 'pvp':
                $this->pvp = $valor;
                break;

            default:
                return null;
                break;
        }
    }

    public function __toString() {
        return "Marca: " . $this->marca . "; Stock: " . $this->marca . "; PVP: " . $this->pvp;
    }
}