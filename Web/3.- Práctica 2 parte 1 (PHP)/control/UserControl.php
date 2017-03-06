<?php
include_once('persistence/UserBD.php');
include_once('model/Usuario.php');

class UserControl {
	
	public function getAllUsers() {
		$queryResult = UserDB::getAllUsers();
		$users = array();
		foreach ($queryResult as $user) {
			array_push($users,
				new Usuario(
					$user['id'],
					$user['usuario'],
					$user['clave'],
					$user['nombre'],
					$user['tipo'],
					$user['poblacion'],
					$user['direccion']
				));
		}
		return $users;
	}
	
}
?>