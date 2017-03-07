<?php
include_once('Connection.php');

class UserDB {

    public static function editUser($id, $password, $nombre, $tipo, $poblacion, $direccion) {
        $connection = new Connection("./datos.db");
        try
        {
            $connectionLink = $connection->connect();
            $connectionLink->exec("PRAGMA encoding='UTF-8';");
            $connectionLink->exec("PRAGMA foreign_keys = ON;");
            $connectionLink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if ($password != "") {
                $data = $connectionLink->prepare("UPDATE usuarios SET clave = :clave, nombre = :nombre, tipo = :tipo, poblacion = :poblacion, direccion = :direccion WHERE id = :id");
                $data->bindParam(':id', $id, PDO::PARAM_INT);
                $data->bindParam(':clave', $password, PDO::PARAM_STR);
                $data->bindParam(':nombre', $nombre, PDO::PARAM_STR);
                $data->bindParam(':tipo', $tipo, PDO::PARAM_INT);
                $data->bindParam(':poblacion', $poblacion, PDO::PARAM_STR);
                $data->bindParam(':direccion', $direccion, PDO::PARAM_STR);
            } else {
                $data = $connectionLink->prepare("UPDATE usuarios SET nombre = :nombre, tipo = :tipo, poblacion = :poblacion, direccion = :direccion WHERE id = :id");
                $data->bindParam(':id', $id, PDO::PARAM_INT);
                $data->bindParam(':nombre', $nombre, PDO::PARAM_STR);
                $data->bindParam(':tipo', $tipo, PDO::PARAM_INT);
                $data->bindParam(':poblacion', $poblacion, PDO::PARAM_STR);
                $data->bindParam(':direccion', $direccion, PDO::PARAM_STR);
            }
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

	public static function getAllUsers() {
		$connection = new Connection("./datos.db");
		try
		{
			$connectionLink = $connection->connect();
			$connectionLink->exec("PRAGMA encoding='UTF-8';");
			$connectionLink->exec("PRAGMA foreign_keys = ON;");
			$connectionLink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$data = $connectionLink->query("SELECT * FROM usuarios;");
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

	public static function getUserByID($id) {
        $connection = new Connection("./datos.db");
        try
        {
            $connectionLink = $connection->connect();
            $connectionLink->exec("PRAGMA encoding='UTF-8';");
            $connectionLink->exec("PRAGMA foreign_keys = ON;");
            $connectionLink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $data = $connectionLink->prepare("SELECT * FROM usuarios WHERE id = :id;");
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

	public static function deleteUserByID($id) {
        $connection = new Connection("./datos.db");
        try
        {
            $connectionLink = $connection->connect();
            $connectionLink->exec("PRAGMA encoding='UTF-8';");
            $connectionLink->exec("PRAGMA foreign_keys = ON;");
            $connectionLink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $data = $connectionLink->prepare("DELETE FROM usuarios WHERE id = :id;");
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

    public static function registerUser($username, $password, $name, $type, $poblation, $direction) {
        $connection = new Connection("./datos.db");
        try
        {
            $connectionLink = $connection->connect();
            $connectionLink->exec("PRAGMA encoding='UTF-8';");
            $connectionLink->exec("PRAGMA foreign_keys = ON;");
            $connectionLink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $data = $connectionLink->prepare("INSERT INTO usuarios (usuario, clave, nombre, tipo, poblacion, direccion) VALUES (:usuario, :clave, :nombre, :tipo, :poblacion, :direccion);");
            $data->bindParam(":usuario", $username, PDO::PARAM_STR);
            $data->bindParam(":clave", $password, PDO::PARAM_STR);
            $data->bindParam(":nombre", $name, PDO::PARAM_STR);
            $data->bindParam(":tipo", $type, PDO::PARAM_INT);
            $data->bindParam(":poblacion", $poblation, PDO::PARAM_STR);
            $data->bindParam(":direccion", $direction, PDO::PARAM_STR);
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
?>