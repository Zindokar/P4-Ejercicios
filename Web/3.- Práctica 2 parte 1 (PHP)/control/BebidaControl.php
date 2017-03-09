<?php
include 'persistence/BebidaDB.php';
include 'model/Bebida.php';

class BebidaControl {
    public function getAllDrinks() {
        $queryResult = BebidaDB::getAllDrinks();
        $drinks = array();
        foreach ($queryResult as $drink) {
            array_push($drinks,
                new Bebida(
                    $drink['id'],
                    $drink['marca'],
                    $drink['stock'],
                    $drink['PVP']
                ));
        }
        return $drinks;
    }

    public function getDrinkByID($id) {
        $queryResult = BebidaDB::getDrinkByID($id);
        $drink = $queryResult->fetch(PDO::FETCH_ASSOC);
        return new Bebida(
            $drink['id'],
            $drink['marca'],
            $drink['stock'],
            $drink['PVP']
        );
    }

    public function decreaseStockByDrinkID($id, $quantity) {
        BebidaDB::decreaseStockByDrinkID($id, $quantity);
    }

}