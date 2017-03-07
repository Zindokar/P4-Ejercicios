<?php
include_once('persistence/LineasPedidoDB.php');
include_once('model/LineasPedido.php');

class LineasPedidoControl {

    public function insertOrderItem($orderid, $drinkid, $quantity, $pvp) {
        LineasPedidoDB::insertOrderItem($orderid, $drinkid, $quantity, $pvp);
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

}