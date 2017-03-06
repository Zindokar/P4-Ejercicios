<?php
include_once('Connection.php');

class UserBD {
	
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
}
?>