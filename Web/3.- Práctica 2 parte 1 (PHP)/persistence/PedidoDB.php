<?php
include_once('Connection.php');

class PedidoDB {

    public static function getAllDeliveriesByUserID($id) {
        $connection = new Connection("./datos.db");
        try
        {
            $connectionLink = $connection->connect();
            $connectionLink->exec("PRAGMA encoding='UTF-8';");
            $connectionLink->exec("PRAGMA foreign_keys = ON;");
            $connectionLink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $data = $connectionLink->prepare("SELECT * FROM pedidos WHERE idcliente = :idcliente;");
            $data->bindParam(':idcliente', $id, PDO::PARAM_INT);
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

    public static function getLastOrderID() {
        $connection = new Connection("./datos.db");
        try
        {
            $connectionLink = $connection->connect();
            $connectionLink->exec("PRAGMA encoding='UTF-8';");
            $connectionLink->exec("PRAGMA foreign_keys = ON;");
            $connectionLink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $data = $connectionLink->query("SELECT Max(id) as lastID FROM pedidos;");
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

    public static function insertNewOrder($userid, $poblation, $address, $createtime, $pvp) {
        $connection = new Connection("./datos.db");
        try
        {
            $connectionLink = $connection->connect();
            $connectionLink->exec("PRAGMA encoding='UTF-8';");
            $connectionLink->exec("PRAGMA foreign_keys = ON;");
            $connectionLink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $data = $connectionLink->prepare("INSERT INTO pedidos (idcliente, poblacionentrega, direccionentrega, horacreacion, idrepartidor, horaasignacion, horareparto, horaentrega, PVP) VALUES (:idcliente, :poblacionentrega, :direccionentrega, :horacreacion, null, null, '0', '0', :pvp);");
            $data->bindParam(':idcliente', $userid, PDO::PARAM_INT);
            $data->bindParam(':poblacionentrega', $poblation, PDO::PARAM_STR);
            $data->bindParam(':direccionentrega', $address, PDO::PARAM_STR);
            $data->bindParam(':horacreacion', $createtime, PDO::PARAM_INT);
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