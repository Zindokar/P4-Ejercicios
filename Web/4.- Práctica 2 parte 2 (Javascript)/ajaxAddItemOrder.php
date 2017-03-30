<?php
include_once('control/PedidoControl.php');
$res = new stdClass();
$res->added = false; //Formato objeto con propiedad deleted (por defecto a false)
$res->message = ''; //Mensaje en caso de error
$res->pvp = 0;
$res->id = 0;
$res->bebida = "";
$res->unidades = "";
$res->pvpbebida = 0;
try {
    $datoscrudos = file_get_contents("php://input"); //Leemos los datos
    $datos = json_decode($datoscrudos);
    $pedidoControl = new PedidoControl();
    $pedidoControl->updateOrder($datos->idbebida, $datos->unidades);
    $lineasPedidoControl = new LineasPedidoControl();
    $lineasPedidoActual = $lineasPedidoControl->getLastItemOrder();
    $res->id = $lineasPedidoActual->id;
    $bebidaControl = new BebidaControl();
    $bebidaActual = $bebidaControl->getDrinkByID($datos->idbebida);
    $res->bebida = $bebidaActual->marca;
    $res->unidades = $datos->unidades;
    $res->pvpbebida = $bebidaActual->pvp;
    $res->pvp = PedidoDB::getCurrentOrderByClientID($_SESSION['user']['id'])[0]['PVP'];
    $res->added = true;
    $res->message = 'Elemento añadido';
} catch(Exception $e) {
    $res->message = $e->getMessage(); //En caso de error se envia la información de error al navegador
    $res->added = false;
}
header('Content-type: application/json');
echo json_encode($res);
