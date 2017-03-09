<?php

class Pedido {
    private $id, $idcliente, $horacreacion, $poblacionentrega, $direccionentrega,
        $idrepartidor, $horaasignacion, $horareparto, $horaentrega, $pvp;

    public function __construct($id, $idcliente, $horacreacion, $poblacionentrega, $direccionentrega,
                                $idrepartidor, $horaasignacion, $horareparto, $horaentrega, $pvp) {
        $this->id = $id;
        $this->idcliente = $idcliente;
        $this->horacreacion = $horacreacion;
        $this->poblacionentrega = $poblacionentrega;
        $this->direccionentrega = $direccionentrega;
        $this->idrepartidor = $idrepartidor;
        $this->horaasignacion = $horaasignacion;
        $this->horareparto = $horareparto;
        $this->horaentrega = $horaentrega;
        $this->pvp = $pvp;
    }

    public function __get($atributo) {
        switch ($atributo) {
            case 'id':
                return $this->id;
                break;

            case 'idcliente':
                return $this->idcliente;
                break;

            case 'horacreacion':
                return $this->horacreacion;
                break;

            case 'poblacionentrega':
                return $this->poblacionentrega;
                break;

            case 'direccionentrega':
                return $this->direccionentrega;
                break;

            case 'idrepartidor':
                return $this->idrepartidor;
                break;

            case 'horaasignacion':
                return $this->horaasignacion;
                break;

            case 'horareparto':
                return $this->horareparto;
                break;

            case 'horaentrega':
                return $this->horaentrega;
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
            case 'idcliente':
                $this->idcliente = $valor;
                break;

            case 'horacreacion':
                $this->horacreacion = $valor;
                break;

            case 'poblacionentrega':
                $this->poblacionentrega = $valor;
                break;

            case 'direccionentrega':
                $this->direccionentrega = $valor;
                break;

            case 'idrepartidor':
                $this->idrepartidor = $valor;
                break;

            case 'horaasignacion':
                $this->horaasignacion = $valor;
                break;

            case 'horareparto':
                $this->horareparto = $valor;
                break;

            case 'horaentrega':
                $this->horaentrega = $valor;
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
        return $this->id . " " . $this->idcliente . " " . $this->pvp;
    }

    public function printDateFromEpoch($date) {
        $dateFormatted = "";
        if (!($date == null || $date == "" || $date == 0)) {
            $dateFormatted = date('D j M Y \- H:i:s', $date);
        }
        return $dateFormatted;
    }

    public function getDeliveryStatus() {
        // Si no hay hora de asignación, toca empezar a repartir
        if ($this->horareparto == "" || $this->horareparto == 0) {
            return 1;
        } else if ($this->horaentrega == "" || $this->horaentrega == 0) { // No se ha entregado pero está en reparto
            return 2;
        } else { // Entregado
            return 0;
        }
    }
}