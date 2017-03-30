<?php
include_once('control/BebidaControl.php');
include_once('control/PedidoControl.php');

class ClientView {
    public function menu() {
        echo '<div class="cabecera">
                <ul class="menu">
                    <li class="menuItem"><a class="menuLink" href="index.php?page=1">Listado de bebidas</a></li>
                    <li class="menuItem"><a class="menuLink" href="index.php?page=2">Crear pedido</a></li>
                    <li class="menuItem"><a class="menuLink" href="index.php?page=3">Listado de pedidos</a></li>
                    <li class="menuItem">
                        <form action="index.php" method="post">
                            <input type="submit" name="logout" value="Desconectar" />
                        </form>
                    </li>
                </ul>
            </div>';
    }

    public function deleteOrder($id){
        $control = new LineasPedidoControl();
        $control->deleteElement($id);
        $this->orderMenu();
    }
    
    public function drinkList() {
        $control = new BebidaControl();
        $drinks = $control->getAllDrinks();
        echo '<div class="cuerpo">
                <p>Lista de bebidas</p>
                <table class="tabla">
                    <thead>
                        <th>id</th>
                        <th>Marca</th>
                        <th>Stock</th>
                        <th>PVP</th>
                    </thead>
                    <tbody>';
        foreach ($drinks as $drink) {
            echo '<tr><td>' . $drink->id . '</td>';
            echo '<td>' . $drink->marca . '</td>';
            echo '<td>' . $drink->stock . '</td>';
            echo '<td>' . $drink->pvp . '</td></tr>';
        }
        echo '</tbody></table></div>';
    }

    public function orderMenu() {
        $control = new BebidaControl();
        $drinks = $control->getAllDrinks();
        echo '<div class="cuerpo">
                <p>Crea o actualiza tu pedido</p>
                <table class="tabla">
                    <tr>
                        <td><span class="negrita">Selecciona bebida</span></td>
                        <td>
                            <select name="drinkID" id="drinkID">';
                                foreach ($drinks as $drink) {
                                    echo '<option value="' . $drink->id . '">' . $drink->marca . '</option>';
                                }
        echo '              </select>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="negrita">Cantidad</span></td>
                        <td>
                            <input type="text" name="drinkQuantity" id="drinkQuantity" />
                            <span id="drinkQuantityDiv" style="display: none;"></span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="button" value="Actualizar pedido" onclick="addItemOrder();" /></td>
                    </tr>
                    <tr><form action="index.php?page=3" method="post"><td colspan="2"><input type="submit" name="finishOrder" value="Terminar pedido" /></form></td></tr>
                </table>';
        $this->printCurrentOrder();
    }

    public function printCurrentOrder() {
        $orderItemsControl = new LineasPedidoControl();
        $orderItems = $orderItemsControl->getAllItemsFromUnfinishedOrderByClientID($_SESSION['user']['id']);
        echo '<div class="cuerpo">';
            echo '<p>Listado de bebidas del pedido sin finalizar</p>';
            echo '<table class="tabla" id="itemOrderPVPTable">';
            $currentPVP = PedidoDB::getCurrentOrderByClientID($_SESSION['user']['id']);
            echo "<tr><td><span class='negrita'>Total: </span></td><td><span class='negrita' id='pvpTotal'>" . ($currentPVP == null ? "0" : $currentPVP[0]['PVP']) . "</span> €</td></tr></table>";
            echo '<table class="tabla" id="itemOrderTable">
                    <thead>
                        <th>id</th>
                        <th>Bebida</th>
                        <th>Unidades</th>
                        <th>PVP</th>
                        <th>Acción</th>
                    </thead>
                    <tbody>';
                    $bebidaControl = new BebidaControl();
                    foreach ($orderItems as $item) {
                        echo '<tr id="fila' . $item->id . '"><td>' . $item->id . '</td>';
                        $marcaActual = $bebidaControl->getDrinkByID($item->idbebida)->marca;
                        echo '<td>' . $marcaActual . '</td>';
                        echo '<td>' . $item->unidades . '</td>';
                        echo '<td>' . $item->pvp . '</td>';
                        echo '<td>
                                <input type="button" value="Eliminar" onclick=\'deleteItemByID(' . $item->id . ', "' . $marcaActual . '");\' />
                              </td></tr>';
                    }
                echo '</tbody></table>';
        echo '</div>';
    }

    public function orderList($id) {
        $control = new PedidoControl();
        $deliveries = $control->getAllDeliveriesByUserID($id);
        echo '<div class="cuerpo">
                <p>Lista de sus pedidos</p>
                <table class="tabla">
                    <thead>
                        <th>id</th>
                        <th>Hora creación</th>
                        <th>Población entrega</th>
                        <th>Dirección entrega</th>
                        <th>Repartidor</th>
                        <th>Hora asignación</th>
                        <th>Hora reparto</th>
                        <th>Hora entrega</th>
                        <th>PVP</th>
                        <th>Estado</th>
                        <th></th>
                    </thead>
                    <tbody>';
        foreach ($deliveries as $delivery) {
            echo '<tr><td>' . $delivery->id . '</td>';
            echo '<td>' . $delivery->printDateFromEpoch($delivery->horacreacion) . '</td>';
            echo '<td>' . $delivery->poblacionentrega . '</td>';
            echo '<td>' . $delivery->direccionentrega . '</td>';
            echo '<td>' . $delivery->idrepartidor . '</td>';
            echo '<td>' . $delivery->printDateFromEpoch($delivery->horaasignacion) . '</td>';
            echo '<td>' . $delivery->printDateFromEpoch($delivery->horareparto) . '</td>';
            echo '<td>' . $delivery->printDateFromEpoch($delivery->horaentrega) . '</td>';
            echo '<td>' . $delivery->pvp . '</td>';
             $deliveryStatus = "";
            switch ($delivery->getDeliveryStatus()) {
                case 0:
                    $deliveryStatus = "No finalizado";
                    break;
                    
                case 1:
                    $deliveryStatus = "Sin asignar";
                    break;
                    
                case 2:
                    $deliveryStatus = "Asignado";
                    break;
                         
                case 3:
                    $deliveryStatus = "En reparto";
                    break;
                    
                case 4:
                    $deliveryStatus = "Entregado";
                    break;
                    
                default:
                    $deliveryStatus = "Estado desconocido";
                    break;
                    
            }
            echo '<td>' . $deliveryStatus . '</td>';
            echo '<td><a href="index.php?page=4&orderID=' . $delivery->id . '" target="_self">Detalles</a></td></tr>';
        }
        echo '</tbody></table></div>';
    }

    public function orderDetails($id) {
        $control = new LineasPedidoControl();
        $drinkItems = $control->getAllItemsFromOrderID($id);
        echo '<div class="cuerpo">
                <p>Pedido con id: <span class="negrita">' . $id . '</span></p>
                <table class="tabla">
                    <thead>
                        <th>id</th>
                        <th>Bebida</th>
                        <th>Unidades</th>
                        <th>PVP</th>
                    </thead>
                    <tbody>';
        $bebidaControl = new BebidaControl();
        foreach ($drinkItems as $item) {
            echo '<tr><td>' . $item->id . '</td>';
            echo '<td>' . $bebidaControl->getDrinkByID($item->idbebida)->marca . '</td>';
            echo '<td>' . $item->unidades . '</td>';
            echo '<td>' . $item->pvp . '</td></tr>';
        }
        echo '</tbody></table></div>';
    }

}
