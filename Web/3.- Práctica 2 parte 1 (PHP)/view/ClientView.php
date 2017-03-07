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

    public function drinkList() {
        $control = new BebidaControl();
        $drinks = $control->getAllDrinks();
        echo '<div class="cuerpo">
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

    public function newOrder() {
        $control = new BebidaControl();
        $drinks = $control->getAllDrinks();
        echo '<div class="cuerpo">
                <form action="index.php" method="post">
                    <table class="tabla">
                        <thead>
                            <th><span class="negrita">Bebidas</span></th>
                            <th><span class="negrita">Cantidad</span></th>
                            <th></th>
                        </thead>
                        <tbody>';
        foreach ($drinks as $drink) {
            echo '<tr><td><span class="negrita">' . $drink->marca . '</span></td>';
            echo '<td>
                    <input type="text" name="drinkQuantity[]" placeholder="Max: ' . $drink->stock . '" />' .
                    '<input type="hidden" name="drinkID[]" value="' . $drink->id . '" />' .
                    '<input type="hidden" name="drinkPVP[]" value="' . $drink->pvp . '" />' .
                '</td>';
        }
        echo '<tr><td colspan="2"><input type="submit" value="Enviar" name="newOrder" /></td></tr>';
        echo '</tbody></table></form></div>';
    }

    public function orderList($id) {
        $control = new PedidoControl();
        $deliveries = $control->getAllDeliveriesByUserID($id);
        echo '<div class="cuerpo">
                <table class="tabla">
                    <thead>
                        <th>id</th>
                        <th>Cliente</th>
                        <th>Hora creación</th>
                        <th>Población entrega</th>
                        <th>Dirección entrega</th>
                        <th>Repartidor</th>
                        <th>Hora asignación</th>
                        <th>Hora reparto</th>
                        <th>Hora entrega</th>
                        <th>PVP</th>
                        <th></th>
                    </thead>
                    <tbody>';
        foreach ($deliveries as $delivery) {
            echo '<tr><td>' . $delivery->id . '</td>';
            echo '<td>' . $delivery->idcliente . '</td>';
            echo '<td>' . $delivery->printDateFromEpoch($delivery->horacreacion) . '</td>';
            echo '<td>' . $delivery->poblacionentrega . '</td>';
            echo '<td>' . $delivery->direccionentrega . '</td>';
            echo '<td>' . $delivery->idrepartidor . '</td>';
            echo '<td>' . $delivery->printDateFromEpoch($delivery->horaasignacion) . '</td>';
            echo '<td>' . $delivery->printDateFromEpoch($delivery->horareparto) . '</td>';
            echo '<td>' . $delivery->printDateFromEpoch($delivery->horaentrega) . '</td>';
            echo '<td>' . $delivery->pvp . '</td>';
            echo '<td><a href="index.php?page=4&orderID=' . $delivery->id . '" target="_self">Detalles</a></td></tr>';
        }
        echo '</tbody></table></div>';
    }

    public function orderDetails($id) {
        $control = new LineasPedidoControl();
        $drinkItems = $control->getAllItemsFromOrderID($id);
        echo '<div class="cuerpo">
                <table class="tabla">
                    <thead>
                        <th>id</th>
                        <th>Pedido</th>
                        <th>Bebida</th>
                        <th>Unidades</th>
                        <th>PVP</th>
                    </thead>
                    <tbody>';
        foreach ($drinkItems as $item) {
            echo '<tr><td>' . $item->id . '</td>';
            echo '<td>' . $item->idpedido . '</td>';
            echo '<td>' . $item->idbebida . '</td>';
            echo '<td>' . $item->unidades . '</td>';
            echo '<td>' . $item->pvp . '</td></tr>';
        }
        echo '</tbody></table></div>';
    }

}
