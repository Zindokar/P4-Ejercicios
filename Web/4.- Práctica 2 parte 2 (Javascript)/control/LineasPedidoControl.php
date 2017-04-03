<?php
include_once('persistence/LineasPedidoDB.php');
include_once('model/LineasPedido.php');
include_once ('control/PedidoControl.php');

class LineasPedidoControl {

    public function getItemOrderByID($id) {
        $item = LineasPedidoDB::getItemOrderByID($id);
        $item = $item->fetch(PDO::FETCH_ASSOC);
        return new LineasPedido(
            $item['id'],
            $item['idpedido'],
            $item['idbebida'],
            $item['unidades'],
            $item['PVP']
        );
    }

    public function insertOrderItem($orderid, $drinkid, $quantity, $pvp) {
        LineasPedidoDB::insertOrderItem($orderid, $drinkid, $quantity, $pvp);
    }

    public function getLastItemOrder() {
        $item = LineasPedidoDB::getLastItemOrder();
        $item = $item->fetch(PDO::FETCH_ASSOC);
        return new LineasPedido(
            $item['id'],
            $item['idpedido'],
            $item['idbebida'],
            $item['unidades'],
            $item['PVP']
        );
    }

    public function getAllItemsFromUnfinishedOrderByClientID($id) {
        $queryResult = LineasPedidoDB::getAllItemsFromUnfinishedOrderByClientID($id);
        $drinkItems = array();
        foreach ($queryResult as $drink) {
            array_push($drinkItems,
                new LineasPedido(
                    $drink['id'],
                    $drink['idpedido'],
                    $drink['idbebida'],
                    $drink['unidades'],
                    $drink['PVP']
                ));
        }
        return $drinkItems;
    }

    public function insertOrUpdateNewElement($drinkID, $quantity, $orderID, $drinkPVP) {
        LineasPedidoDB::insertOrUpdateNewElement($drinkID, $quantity, $orderID, $drinkPVP);
    }
    
    public function deleteElement($id){
        $item = $this->getItemOrderByID($id);
        $pedidoControl = new PedidoControl();
        $bebidaControl = new BebidaControl();
        LineasPedidoDB::deleteElement($id);
        session_start();
        $pedidoControl->updateDeliveryPVP($item->unidades, (-1) * $item->pvp, $_SESSION['user']['id']);
        $bebidaControl->decreaseStockByDrinkID($item->idbebida, (-1) * $item->unidades);
    }

    public function getAllItemsFromOrderID($id) {
        $queryResult = LineasPedidoDB::getAllItemsFromOrderID($id);
        $drinkItems = array();
        foreach ($queryResult as $drink) {
            array_push($drinkItems,
                new LineasPedido(
                    $drink['id'],
                    $drink['idpedido'],
                    $drink['idbebida'],
                    $drink['unidades'],
                    $drink['PVP']
                ));
        }
        return $drinkItems;
    }

    public function deleteAllOrderItemsByDeliveryID($id) {
        LineasPedidoDB::deleteAllOrderItemsByDeliveryID($id);
    }

}