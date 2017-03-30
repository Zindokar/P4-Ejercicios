<?php
    include_once('lib.php');
	include_once('view/UnidentifiedUserView.php');
    include_once('view/AdminView.php');
    include_once('view/ClientView.php');
    include_once('view/DeliverymanView.php');

    // Variables de control
    $msg = "";
    $color = "";

    // Llamadas al control de Usuario
    if (isset($_POST['login'])) {
        if (User::login($_POST['userLogin'], $_POST['passLogin'])) {
            $msg = "Identificado correctamente";
            $color = "correcto";
        } else {
            $msg = "Credenciales incorrectas";
            $color = "incorrecto";
        }
    }

    if (isset($_POST['newUser'])) {
        $control = new UserControl();
        $control->registerUser($_POST['newUsername'], $_POST['newPassword'], $_POST['newNombre'], $_POST['newTipo'], $_POST['newPoblacion'], $_POST['newDireccion']);
        $msg = "Usuario registrado";
        $color = "correcto";
    }

    if (isset($_POST['editUser'])) {
        $control = new UserControl();
        $control->editUser($_POST['editID'], $_POST['editPassword'], $_POST['editNombre'], $_POST['editTipo'], $_POST['editPoblacion'], $_POST['editDireccion']);
        $msg = "Usuario editado correctamente";
        $color = "correcto";
    }

    if (isset($_POST['deleteConfirm'])) {
        $control = new UserControl();
        try {
            $control->confirmedToDeleteUserByID($_POST['userID']);
            $msg = "Usuario borrado correctamente";
            $color = "correcto";
        } catch (Exception $e) {
            $msg = $e;
            $color = "incorrecto";
        }
    }

    if (isset($_POST['logout'])) {
        User::logout();
        $msg = "Desconectado correctamente";
        $color = "correcto";
    }

    // Llamadas al control de Pedido
    if (isset($_POST['updateOrder'])) {
        $control = new PedidoControl();
        try {
            $control->updateOrder($_POST['drinkID'], $_POST['drinkQuantity']);
            $msg = "Pedido actualizado correctamente";
            $color = "correcto";
        } catch (Exception $e) {
            $msg = $e->getMessage();
            $color = "incorrecto";
        }
    }

    if (isset($_POST['finishOrder'])) {
        $control = new PedidoControl();
        try {
            $control->finishOrder();
            $msg = "Pedido finalizado correctamente";
            $color = "correcto";
        } catch (Exception $e) {
            $msg = $e->getMessage();
            $color = "incorrecto";
        }
    }

    if (isset($_POST['asignarPedido'])) {
        $control = new PedidoControl();
        $control->assignDelivery($_POST['pedidoID'], $_POST['repartidorID']);
    }

    if (isset($_POST['iniciarEntrega'])) {
        $control = new PedidoControl();
        $control->startDelivery($_POST['pedidoID']);
    }

    if (isset($_POST['finalizarEntrega'])) {
        $control = new PedidoControl();
        $control->finishDelivery($_POST['pedidoID']);
    }
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="view/styles/styles.css">
		<script src="view/js/javascripts.js"></script>
		<title>Distribuidora Krypto</title>
	</head>
	<body>
<?php
    View::start();
    if ($msg != "") {
        echo '<div class="' . $color . '">' . $msg . '</div>';
    }
    // Selector de vistas
    if (isset($_SESSION['user']) && $_SESSION['user']['tipo'] == 1) { // Admin
        View::welcome();
        $view = new AdminView();
        $view->menu();
        // Se puede mejorar
        if (isset($_GET['page'])) {
            switch ($_GET['page']) {
                case 1:
                    $view->createUserForm();
                    break;
                    
                case 2:
                    $view->listAllDeliveries();
                    break;
            }
        } else {
            if (isset($_GET['edit'])) {
                $view->editUser($_GET['edit']);
            } else if (isset($_GET['delete'])) {
                $view->deleteUser($_GET['delete']);
            } else {
                $view->listUsers();
            }
        }
    } else if (isset($_SESSION['user']) && $_SESSION['user']['tipo'] == 2) { // Cliente
        View::welcome();
        $view = new ClientView();
        $view->menu();
        if (isset($_GET['page'])) {
            switch($_GET['page']) {
                default:
                case 1:
                    $view->drinkList();
                    break;

                case 2:
                    if(isset($_POST['iddelete'])){
                        $view->deleteOrder($_POST['iddelete']);
                        break;
                    }else{
                        $view->orderMenu();
                        break;
                    }

                case 3:
                    $view->orderList($_SESSION['user']['id']);
                    break;

                case 4:
                    $view->orderDetails($_GET['orderID']);
                    break;
                    
            }
        } else {
            $view->drinkList();
        }
    } else if (isset($_SESSION['user']) && $_SESSION['user']['tipo'] == 3) { // Repartidor
        View::welcome();
        $view = new DeliverymanView();
        $view->menu();
        if (isset($_GET['page'])) {
            switch ($_GET['page']) {
                default:
                case 1:
                    $view->listAllUnassignedDeliveries();
                    break;

                case 2:
                    $view->listMyDeliveries();
                    break;
            }
        } else {
            $view->listAllUnassignedDeliveries();
        }
    } else { // Usuario no identificado
        $view = new UnidentifiedUserView();
        $view->signInForm();
    }
    View::end();
?>
	</body>
</html>