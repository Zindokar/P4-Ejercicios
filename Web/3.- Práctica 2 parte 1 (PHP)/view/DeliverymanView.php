<?php
include_once('control/PedidoControl.php');

class DeliverymanView {
    public function menu() {
        echo '<div class="cabecera">
                <ul class="menu">
                    <li class="menuItem"><a href="index.php?page=1">Listar pedidos no asignados</a></li>
                    <li class="menuItem"><a href="index.php?page=2">Listar mis pedidos</a></li>
                    <li class="menuItem">
                        <form action="index.php" method="post">
                            <input type="submit" name="logout" value="Desconectar" />
                        </form>
                    </li>
                </ul>
            </div>';
    }

    public function listAllUnassignedDeliveries() {
        $control = new PedidoControl();
        $deliveries = $control->getAllUnassignedDeliveries();
        echo '<div class="cuerpo">
                <p>Listado de pedidos no asignados</p>
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
            echo '<td>
                    <form action="index.php" method="post">
                        <input type="submit" name="asignarPedido" value="Asignarme" />
                        <input type="hidden" name="pedidoID" value="' . $delivery->id . '" />
                        <input type="hidden" name="repartidorID" value="' . $_SESSION['user']['id'] . '" />
                    </form>
                 </td></tr>';
        }
        echo '</tbody></table></div>';
    }

    public function listMyDeliveries() {
        $control = new PedidoControl();
        $deliveries = $control->getAllDeliveriesByDeliverymanID($_SESSION['user']['id']);
        echo '<div class="cuerpo">
                <p>Listado de mis pedidos</p>
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

            $deliveryStatus = $delivery->getDeliveryStatus();
            $buttonMsg = "";
            $buttonName = "";
            if ($deliveryStatus == 1) {
                $buttonMsg = "Iniciar entrega";
                $buttonName = "iniciarEntrega";
            } else if ($deliveryStatus == 2) {
                $buttonMsg = "Finalizar entrega";
                $buttonName = "finalizarEntrega";
            }

            if ($deliveryStatus == 0) {
                echo '<td><span class="negrita">Entregado</span></td>';
            } else {
                echo '<td>
                    <form action="index.php?page=2" method="post">
                        <input type="submit" name="' . $buttonName . '" value="' . $buttonMsg . '" />
                        <input type="hidden" name="pedidoID" value="' . $delivery->id . '" />
                    </form>
                 </td></tr>';
            }
        }
        echo '</tbody></table></div>';
    }
}
