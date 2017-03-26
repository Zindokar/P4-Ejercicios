<?php
include_once('persistence/UserDB.php');
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

	public function getUserByID($id) {
	    $user = UserDB::getUserByID($id);
	    $user = $user->fetch(PDO::FETCH_ASSOC);
	    return new Usuario(
            $user['id'],
            $user['usuario'],
            $user['clave'],
            $user['nombre'],
            $user['tipo'],
            $user['poblacion'],
            $user['direccion']
        );
    }

	public function deleteUserByID($id) {
	    UserDB::deleteUserByID($id);
    }

    public function registerUser($username, $password, $name, $type, $poblation, $direction) {
	    UserDB::registerUser($username, md5($password), $name, $type, $poblation, $direction);
    }

    public function confirmedToDeleteUserByID($id) {
        $controlDelivery = new PedidoControl();
        $deliveriesToDelete = $controlDelivery->getAllDeliveriesByUserID($id);
        $controOrderItems = new LineasPedidoControl();
        // Primero borro las entradas de lineaspedido de los pedidos del usuario
        foreach ($deliveriesToDelete as $delivery) {
            // Debería aumentar el stock si no está entregado el pedido?
            $controOrderItems->deleteAllOrderItemsByDeliveryID($delivery->id);
        }
        // Borro los pedidos del usuario
        $controlDelivery->deleteDeliveriesByUserID($id);
        // Ahora borro el usuario
        $this->deleteUserByID($id);
    }

    public function editUser($id, $password, $nombre, $tipo, $poblacion, $direccion) {
	    if ($password != "") {
	        $password = md5($password);
        }
        UserDB::editUser($id, $password, $nombre, $tipo, $poblacion, $direccion);
    }
}
?>