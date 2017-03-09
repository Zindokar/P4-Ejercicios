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

    public function insertNewOrder($idList, $quantityList, $pvpList) {
        // Comprobamos que exista stock
        $bebidaControl = new BebidaControl();
        for ($i = 0; $i < sizeof($idList); $i++) {
            if ($bebidaControl->getDrinkByID($idList[$i])->stock < $quantityList[$i]) {
                throw new Exception("No hay stock suficiente para hacer el pedido.");
            }
        }

        // Calculamos el pvp total para la tabla pedidos
        $totalPVP = 0.0;
        for ($i = 0; $i < sizeof($idList); $i++) {
            $totalPVP += $pvpList[$i] * $quantityList[$i];
        }

        session_start();
        // Insertamos nuevo pedido
        PedidoDB::insertNewOrder($_SESSION['user']['id'], $_SESSION['user']['poblacion'], $_SESSION['user']['direccion'], time('now'), $totalPVP);
        // Obtenemos ID del último pedido creado para usar el mismo en lineaspedido
        $lastID = PedidoDB::getLastOrderID();
        $lastID = $lastID->fetch(PDO::FETCH_ASSOC);
        $lastID = $lastID['lastID'];
        if ($lastID == "") {
            $lastID = 1;
        }
        // Insertamos las lineaspedido del pedido de una en una por cada bebida
        $controlPedidos = new LineasPedidoControl();
        $controlBebidas = new BebidaControl();
        for ($i = 0; $i < sizeof($idList); $i++) {
            if ($quantityList[$i] != 0 && $quantityList[$i] != "") { // Comprobamos al menos que en los textbox no haya un 0 o vacío
                $controlPedidos->insertOrderItem($lastID, $idList[$i], $quantityList[$i], $pvpList[$i]);
                $controlBebidas->decreaseStockByDrinkID($idList[$i], $quantityList[$i]);
            }
        }
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