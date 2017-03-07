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

    if (isset($_POST['logout'])) {
        User::logout();
        $msg = "Desconectado correctamente";
        $color = "correcto";
    }

    // Llamadas al control de Pedido
    if (isset($_POST['newOrder'])) {
        $control = new PedidoControl();
        $control->insertNewOrder($_POST['drinkID'], $_POST['drinkQuantity'], $_POST['drinkPVP']);
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
                    $view->newOrder();
                    break;

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
    } else { // Usuario no identificado
        $view = new UnidentifiedUserView();
        $view->signInForm();
    }
    View::end();
?>
	</body>
</html>