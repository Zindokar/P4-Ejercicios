<?php
include_once('control/LineasPedidoControl.php');
$res = new stdClass();
$res->deleted = false; //Formato objeto con propiedad deleted (por defecto a false)
$res->message =''; //Mensaje en caso de error
$res->pvp = 0;
try {
    $datoscrudos = file_get_contents("php://input"); //Leemos los datos
    $datos = json_decode($datoscrudos);
    $itemOrderControl = new LineasPedidoControl();
    $itemOrderControl->deleteElement($datos->id);
    $pedidoControl = new PedidoControl();
    $res->pvp = PedidoDB::getCurrentOrderByClientID($_SESSION['user']['id'])[0]['PVP'];
    $res->deleted = true;
    $res->message = 'Elemento borrado';
} catch(Exception $e) {
    $res->message = $e->getMessage(); //En caso de error se envia la información de error al navegador
    $res->deleted = false;
}
header('Content-type: application/json');
echo json_encode($res);
