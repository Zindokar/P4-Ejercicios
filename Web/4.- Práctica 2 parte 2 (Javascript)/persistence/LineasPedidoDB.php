<?php
include_once('Connection.php');

class LineasPedidoDB {

    public static function getItemOrderByID($id) {
        $connection = new Connection("./datos.db");
        try
        {
            $connectionLink = $connection->connect();
            $connectionLink->exec("PRAGMA encoding='UTF-8';");
            $connectionLink->exec("PRAGMA foreign_keys = ON;");
            $connectionLink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $data = $connectionLink->prepare("SELECT * FROM lineaspedido WHERE id = :id;");
            $data->bindParam(':id', $id, PDO::PARAM_INT);
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

    public static function getLastItemOrder() {
        $connection = new Connection("./datos.db");
        try
        {
            $connectionLink = $connection->connect();
            $connectionLink->exec("PRAGMA encoding='UTF-8';");
            $connectionLink->exec("PRAGMA foreign_keys = ON;");
            $connectionLink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $data = $connectionLink->query("SELECT * FROM lineaspedido WHERE id = (SELECT Max(id) as id FROM lineaspedido);");
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

    public static function insertOrUpdateNewElement($drinkID, $quantity, $orderID, $drinkPVP) {
        $connection = new Connection("./datos.db");
        try
        {
            $connectionLink = $connection->connect();
            $connectionLink->exec("PRAGMA encoding='UTF-8';");
            $connectionLink->exec("PRAGMA foreign_keys = ON;");
            $connectionLink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $data = $connectionLink->prepare("UPDATE lineaspedido SET unidades = unidades + :quantity WHERE idbebida = :drinkid AND idpedido = :orderid;");
            $data->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $data->bindParam(':drinkid', $drinkID, PDO::PARAM_INT);
            $data->bindParam(':orderid', $orderID, PDO::PARAM_INT);
            $data->execute();
            $connection = null;
            $connectionLink = null;
			LineasPedidoDB::insertNewElement($drinkID, $quantity, $orderID, $drinkPVP);
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
	
	public static function insertNewElement($drinkID, $quantity, $orderID, $drinkPVP) {
		$connection = new Connection("./datos.db");
        try
        {
		    $connectionLink = $connection->connect();
            $connectionLink->exec("PRAGMA encoding='UTF-8';");
            $connectionLink->exec("PRAGMA foreign_keys = ON;");
            $data = $connectionLink->prepare("INSERT OR IGNORE INTO lineaspedido (idpedido, idbebida, unidades, pvp) VALUES (:orderid, :drinkid, :quantity, :pvp);");
            $data->bindParam(':orderid', $orderID, PDO::PARAM_INT);
            $data->bindParam(':drinkid', $drinkID, PDO::PARAM_INT);
            $data->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $data->bindParam(':pvp', $drinkPVP, PDO::PARAM_STR);
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

    public static function deleteElement($id){
        $connection = new Connection("./datos.db");
        try
        {
            $connectionLink = $connection->connect();
            $connectionLink->exec("PRAGMA encoding='UTF-8';");
            $connectionLink->exec("PRAGMA foreign_keys = ON;");
            $connectionLink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $data = $connectionLink->prepare("DELETE FROM lineaspedido WHERE id=:idlinea");
            $data->bindParam(':idlinea', $id, PDO::PARAM_INT);
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
    
    public static function getAllItemsFromUnfinishedOrderByClientID($id) {
        $connection = new Connection("./datos.db");
        try
        {
            $connectionLink = $connection->connect();
            $connectionLink->exec("PRAGMA encoding='UTF-8';");
            $connectionLink->exec("PRAGMA foreign_keys = ON;");
            $connectionLink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $data = $connectionLink->prepare("SELECT l.id, l.idpedido, l.idbebida, l.unidades, l.PVP FROM lineaspedido l JOIN pedidos p ON l.idpedido = p.id WHERE horacreacion = 0 AND idcliente = :idcliente;");
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