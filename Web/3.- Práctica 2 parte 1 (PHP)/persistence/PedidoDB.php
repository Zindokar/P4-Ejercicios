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
    
    public static function getAllDeliveries() {
        $connection = new Connection("./datos.db");
        try
        {
            $connectionLink = $connection->connect();
            $connectionLink->exec("PRAGMA encoding='UTF-8';");
            $connectionLink->exec("PRAGMA foreign_keys = ON;");
            $connectionLink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $data = $connectionLink->query("SELECT * FROM pedidos;");
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
    
    public static function updateDeliveryPVP($quantity, $drinkpvp, $uid) {
        $connection = new Connection("./datos.db");
        try
        {
            $connectionLink = $connection->connect();
            $connectionLink->exec("PRAGMA encoding='UTF-8';");
            $connectionLink->exec("PRAGMA foreign_keys = ON;");
            $connectionLink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $data = $connectionLink->prepare("UPDATE pedidos SET pvp = pvp + (:quantity * :drinkpvp) WHERE horacreacion = 0 AND idcliente = :idcliente;");
            $data->bindParam(':idcliente', $uid, PDO::PARAM_INT);
            $data->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $data->bindParam(':drinkpvp', $drinkpvp, PDO::PARAM_STR);
            $data->execute();
            $data->closeCursor();
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

    public static function getCurrentOrderByClientID($id) {
        $connection = new Connection("./datos.db");
        try
        {
            $connectionLink = $connection->connect();
            $connectionLink->exec("PRAGMA encoding='UTF-8';");
            $connectionLink->exec("PRAGMA foreign_keys = ON;");
            $connectionLink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $data = $connectionLink->prepare("SELECT * FROM pedidos WHERE horacreacion = 0 AND idcliente = :idcliente;");
            $data->bindParam(':idcliente', $id, PDO::PARAM_INT);
            $data->execute();
            $return=$data->fetchAll();
            $data->closeCursor();
            $connection = null;
            $connectionLink = null;
            return $return;
        }
        catch (Exception $e)
        {
            $connection = null;
            $connectionLink = null;
            throw $e;
        }
        return "";
    }

    public static function finishCurrentOrderByClientID($id) {
        $connection = new Connection("./datos.db");
        try
        {
            $connectionLink = $connection->connect();
            $connectionLink->exec("PRAGMA encoding='UTF-8';");
            $connectionLink->exec("PRAGMA foreign_keys = ON;");
            $connectionLink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $data = $connectionLink->query("UPDATE pedidos SET horacreacion = :horacreacion WHERE horacreacion = 0 AND idcliente = :idcliente;");
            $hora = time('now');
            $data->bindParam(':horacreacion', $hora, PDO::PARAM_INT);
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

    public static function deleteDeliveriesByUserID($id) {
        $connection = new Connection("./datos.db");
        try
        {
            $connectionLink = $connection->connect();
            $connectionLink->exec("PRAGMA encoding='UTF-8';");
            $connectionLink->exec("PRAGMA foreign_keys = ON;");
            $connectionLink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $data = $connectionLink->prepare("DELETE FROM pedidos WHERE idcliente = :idcliente;");
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

    public static function insertNewOrder($userid, $poblation, $address) {
        $connection = new Connection("./datos.db");
        try
        {
            $connectionLink = $connection->connect();
            $connectionLink->exec("PRAGMA encoding='UTF-8';");
            $connectionLink->exec("PRAGMA foreign_keys = ON;");
            $connectionLink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $data = $connectionLink->prepare("INSERT INTO pedidos (idcliente, poblacionentrega, direccionentrega, horacreacion, idrepartidor, horaasignacion, horareparto, horaentrega, PVP) VALUES (:idcliente, :poblacionentrega, :direccionentrega, 0, null, null, 0, 0, 0);");
            $data->bindParam(':idcliente', $userid, PDO::PARAM_INT);
            $data->bindParam(':poblacionentrega', $poblation, PDO::PARAM_STR);
            $data->bindParam(':direccionentrega', $address, PDO::PARAM_STR);
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

    public static function getAllUnassignedDeliveries() {
        $connection = new Connection("./datos.db");
        try
        {
            $connectionLink = $connection->connect();
            $connectionLink->exec("PRAGMA encoding='UTF-8';");
            $connectionLink->exec("PRAGMA foreign_keys = ON;");
            $connectionLink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $data = $connectionLink->query("SELECT * FROM pedidos WHERE idrepartidor IS NULL AND horacreacion <> 0;");
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

    public static function getAllDeliveriesByDeliverymanID($id) {
        $connection = new Connection("./datos.db");
        try
        {
            $connectionLink = $connection->connect();
            $connectionLink->exec("PRAGMA encoding='UTF-8';");
            $connectionLink->exec("PRAGMA foreign_keys = ON;");
            $connectionLink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $data = $connectionLink->query("SELECT * FROM pedidos WHERE idrepartidor = :id;");
            $data->bindParam(":id", $id, PDO::PARAM_INT);
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

    public static function assignDelivery($order, $delivery) {
        $connection = new Connection("./datos.db");
        try
        {
            $connectionLink = $connection->connect();
            $connectionLink->exec("PRAGMA encoding='UTF-8';");
            $connectionLink->exec("PRAGMA foreign_keys = ON;");
            $connectionLink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $data = $connectionLink->query("UPDATE pedidos SET idrepartidor = :idrepartidor, horaasignacion = :horaasignacion WHERE id = :id;");
            $data->bindParam(":id", $order, PDO::PARAM_INT);
            $data->bindParam(":idrepartidor", $delivery, PDO::PARAM_INT);
            $a = time('now');
            $data->bindParam(":horaasignacion", $a, PDO::PARAM_STR);
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

    public static function startDelivery($order) {
        $connection = new Connection("./datos.db");
        try
        {
            $connectionLink = $connection->connect();
            $connectionLink->exec("PRAGMA encoding='UTF-8';");
            $connectionLink->exec("PRAGMA foreign_keys = ON;");
            $connectionLink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $data = $connectionLink->query("UPDATE pedidos SET horareparto = :horareparto WHERE id = :id;");
            $data->bindParam(":id", $order, PDO::PARAM_INT);
            $a = time('now');
            $data->bindParam(":horareparto", $a, PDO::PARAM_STR);
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

    public static function finishDelivery($order) {
        $connection = new Connection("./datos.db");
        try
        {
            $connectionLink = $connection->connect();
            $connectionLink->exec("PRAGMA encoding='UTF-8';");
            $connectionLink->exec("PRAGMA foreign_keys = ON;");
            $connectionLink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $data = $connectionLink->query("UPDATE pedidos SET horaentrega = :horaentrega WHERE id = :id;");
            $data->bindParam(":id", $order, PDO::PARAM_INT);
            $a = time('now');
            $data->bindParam(":horaentrega", $a, PDO::PARAM_STR);
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