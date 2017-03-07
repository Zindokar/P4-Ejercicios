<?php
include_once('Connection.php');

class LineasPedidoDB {

    public static function getAllItemsFromOrderID($id) {
        $connection = new Connection("./datos.db");
        try
        {
            $connectionLink = $connection->connect();
            $connectionLink->exec("PRAGMA encoding='UTF-8';");
            $connectionLink->exec("PRAGMA foreign_keys = ON;");
            $connectionLink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $data = $connectionLink->prepare("SELECT * FROM lineaspedido WHERE idpedido = :idpedido;");
            $data->bindParam(':idpedido', $id, PDO::PARAM_INT);
            $data->execute();
            $connection = null;
            $connectionLink = null;
            return $data;
        }
        catch (Exception $e)
        {
            $connection = null;
            $connectionLink = null;
            throw $e;
        }
        return "";
    }

    public static function deleteAllOrderItemsByDeliveryID($id) {
        $connection = new Connection("./datos.db");
        try
        {
            $connectionLink = $connection->connect();
            $connectionLink->exec("PRAGMA encoding='UTF-8';");
            $connectionLink->exec("PRAGMA foreign_keys = ON;");
            $connectionLink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $data = $connectionLink->prepare("DELETE FROM lineaspedido WHERE idpedido = :idpedido;");
            $data->bindParam(':idpedido', $id, PDO::PARAM_INT);
            $data->execute();
            $connection = null;
            $connectionLink = null;
            return $data;
        }
        catch (Exception $e)
        {
            $connection = null;
            $connectionLink = null;
            throw $e;
        }
        return "";
    }

    public static function insertOrderItem($orderid, $drinkid, $quantity, $pvp) {
        $connection = new Connection("./datos.db");
        try
        {
            $connectionLink = $connection->connect();
            $connectionLink->exec("PRAGMA encoding='UTF-8';");
            $connectionLink->exec("PRAGMA foreign_keys = ON;");
            $connectionLink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $data = $connectionLink->prepare("INSERT INTO lineaspedido (idpedido, idbebida, unidades, PVP) VALUES (:idpedido, :idbebida, :unidades, :pvp);");
            $data->bindParam(':idpedido', $orderid, PDO::PARAM_INT);
            $data->bindParam(':idbebida', $drinkid, PDO::PARAM_INT);
            $data->bindParam(':unidades', $quantity, PDO::PARAM_INT);
            $data->bindParam(':pvp', $pvp, PDO::PARAM_STR);
            $data->execute();
            $connection = null;
            $connectionLink = null;
            return $data;
        }
        catch (Exception $e)
        {
            $connection = null;
            $connectionLink = null;
            throw $e;
        }
        return "";
    }

}