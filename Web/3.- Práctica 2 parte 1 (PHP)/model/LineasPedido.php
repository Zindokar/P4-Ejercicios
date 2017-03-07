<?php

class LineasPedido {
    private $id, $idpedido, $idbebida, $unidades, $pvp;

    public function __construct($id, $idpedido, $idbebida, $unidades, $pvp) {
        $this->id = $id;
        $this->idpedido = $idpedido;
        $this->idbebida = $idbebida;
        $this->unidades = $unidades;
        $this->pvp = $pvp;
    }

    public function __get($atributo) {
        switch ($atributo) {
            case 'id':
                return $this->id;
                break;

            case 'idpedido':
                return $this->idpedido;
                break;

            case 'idbebida':
                return $this->idbebida;
                break;

            case 'unidades':
                return $this->unidades;
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
            case 'idpedido':
                $this->idpedido = $valor;
                break;

            case 'idbebida':
                $this->idbebida = $valor;
                break;

            case 'unidades':
                $this->unidades = $valor;
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
        return $this->id . " " . $this->unidades . " " . $this->pvp;
    }
}