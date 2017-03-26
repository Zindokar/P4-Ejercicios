<?php
include_once('persistence/PedidoDB.php');
include_once('model/Pedido.php');
include_once('LineasPedidoControl.php');

class PedidoControl {

    public function getAllDeliveriesByUserID($id) {
        $queryResult = PedidoDB::getAllDeliveriesByUserID($id);
        $deliveries = array();
        foreach ($queryResult as $delivery) {
            array_push($deliveries,
                new Pedido(
                    $delivery['id'],
                    $delivery['idcliente'],
                    $delivery['horacreacion'],
                    $delivery['poblacionentrega'],
                    $delivery['direccionentrega'],
                    $delivery['idrepartidor'],
                    $delivery['horaasignacion'],
                    $delivery['horareparto'],
                    $delivery['horaentrega'],
                    $delivery['PVP']
                ));
        }
        return $deliveries;
    }

    public function getAllDeliveries() {
        $queryResult = PedidoDB::getAllDeliveries();
        $deliveries = array();
        foreach ($queryResult as $delivery) {
            array_push($deliveries,
                new Pedido(
                    $delivery['id'],
                    $delivery['idcliente'],
                    $delivery['horacreacion'],
                    $delivery['poblacionentrega'],
                    $delivery['direccionentrega'],
                    $delivery['idrepartidor'],
                    $delivery['horaasignacion'],
                    $delivery['horareparto'],
                    $delivery['horaentrega'],
                    $delivery['PVP']
                ));
        }
        return $deliveries;
    }

    public function finishOrder() {
        session_start();
        $currentOrder = PedidoDB::getCurrentOrderByClientID($_SESSION['user']['id']);
        if (count($currentOrder) == 0) {
            throw new Exception("No tiene creado ningún pedido, actualícelo primero.");
        }
        PedidoDB::finishCurrentOrderByClientID($_SESSION['user']['id']);
    }

    public function updateOrder($drinkID, $quantity) {
        // Comprobar que exista pedido sin finalizar
        session_start();
		
		$currentOrder = PedidoDB::getCurrentOrderByClientID($_SESSION['user']['id']);
        // Si no existe crear un pedido con horacreacion = 0
        if (count($currentOrder) == 0) {
            PedidoDB::insertNewOrder($_SESSION['user']['id'], $_SESSION['user']['poblacion'], $_SESSION['user']['direccion']);
            $currentOrder = PedidoDB::getCurrentOrderByClientID($_SESSION['user']['id']);
        }
        $currentOrderID = $currentOrder[0]['id'];

        // Comprobamos que exista stock
        $bebidaControl = new BebidaControl();
        $drink = $bebidaControl->getDrinkByID($drinkID);
        if ($drink->stock < $quantity) {
            throw new Exception("No hay stock suficiente para hacer el pedido.");
        }

        // Insertamos o actualizamos los elementos del pedido
        $controlPedidos = new LineasPedidoControl();
        $controlPedidos->insertOrUpdateNewElement($drinkID, $quantity, $currentOrderID, $drink->pvp);

        // Disminuimos el Stock
        $bebidaControl->decreaseStockByDrinkID($drinkID, $quantity);
        PedidoDB::updateDeliveryPVP($quantity, $drink->pvp, $_SESSION['user']['id']);
    }

    public function deleteDeliveriesByUserID($id) {
        PedidoDB::deleteDeliveriesByUserID($id);
    }

    public function getAllUnassignedDeliveries() {
        $queryResult = PedidoDB::getAllUnassignedDeliveries();
        $deliveries = array();
        foreach ($queryResult as $delivery) {
            array_push($deliveries,
                new Pedido(
                    $delivery['id'],
                    $delivery['idcliente'],
                    $delivery['horacreacion'],
                    $delivery['poblacionentrega'],
                    $delivery['direccionentrega'],
                    $delivery['idrepartidor'],
                    $delivery['horaasignacion'],
                    $delivery['horareparto'],
                    $delivery['horaentrega'],
                    $delivery['PVP']
                ));
        }
        return $deliveries;
    }

    public function getAllDeliveriesByDeliverymanID($id) {
        $queryResult = PedidoDB::getAllDeliveriesByDeliverymanID($id);
        $deliveries = array();
        foreach ($queryResult as $delivery) {
            array_push($deliveries,
                new Pedido(
                    $delivery['id'],
                    $delivery['idcliente'],
                    $delivery['horacreacion'],
                    $delivery['poblacionentrega'],
                    $delivery['direccionentrega'],
                    $delivery['idrepartidor'],
                    $delivery['horaasignacion'],
                    $delivery['horareparto'],
                    $delivery['horaentrega'],
                    $delivery['PVP']
                ));
        }
        return $deliveries;
    }

    public function assignDelivery($order, $delivery) {
        PedidoDB::assignDelivery($order, $delivery);
    }

    public function startDelivery($order) {
        PedidoDB::startDelivery($order);
    }

    public function finishDelivery($order) {
        PedidoDB::finishDelivery($order);
    }
}