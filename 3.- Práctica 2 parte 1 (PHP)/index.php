<?php
    include_once('lib.php');
	include_once('view/UnidentifiedUserView.php');
    include_once('view/AdminView.php');
    include_once('view/ClientView.php');
    include_once('view/DeliverymanView.php');

    // Variables de control
    $msg = "";

    // Llamadas al control
    if (isset($_POST['login'])) {
        if (User::login($_POST['userLogin'], $_POST['passLogin'])) {
            $msg = "Identificado correctamente";
        } else {
            $msg = "Credenciales incorrectas";
        }
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
        echo '<div class="correcto">' . $msg . '</div>';
    }
    // Selector de vistas
    if (isset($_SESSION['user']) && $_SESSION['user']['tipo'] == 1) { // Admin
        $view = new AdminView();
    } else if (isset($_SESSION['user']) && $_SESSION['user']['tipo'] == 2) { // Cliente
        $view = new ClientView();

    } else if (isset($_SESSION['user']) && $_SESSION['user']['tipo'] == 3) { // Repartidor
        $view = new DeliverymanView();
    } else { // Usuario no identificado
        $view = new UnidentifiedUserView();
        $view->signInForm();
    }
    View::end();
?>
	</body>
</html>