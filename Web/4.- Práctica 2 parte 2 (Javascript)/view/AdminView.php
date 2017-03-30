<?php
include_once('control/UserControl.php');
include_once('control/PedidoControl.php');
include_once('control/LineasPedidoControl.php');

class AdminView {
    public function menu() {
        echo '<div class="cabecera">
                <ul class="menu">
                    <li class="menuItem"><a href="index.php">Listar usuarios</a></li>
                    <li class="menuItem"><a href="index.php?page=1">Crear usuario</a></li>
                    <li class="menuItem"><a href="index.php?page=2">Listar pedidos</a></li>
                    <li class="menuItem">
                        <form action="index.php" method="post">
                            <input type="submit" name="logout" value="Desconectar" />
                        </form>
                    </li>
                </ul>
            </div>';
    }
    
    public function listAllDeliveries() {
        $control = new PedidoControl();
        $deliveries = $control->getAllDeliveries();
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
            echo '<td><a href="index.php?page=3&orderID=' . $delivery->id . '" target="_self">Detalles</a></td></tr>';
        }
        echo '</tbody></table></div>';
    }

    public function listUsers() {
        $control = new UserControl();
        $users = $control->getAllUsers();
        echo '<div class="cuerpo">
                <p>Listado de usuarios</p>
                <table class="tabla">
                    <thead>
                        <th>id</th>
                        <th>Usuario</th>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Polación</th>
                        <th>Dirección</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </thead>
                    <tbody>';
        foreach ($users as $user) {
            echo '<tr><td>' . $user->id . '</td>';
            echo '<td>' . $user->usuario . '</td>';
            echo '<td>' . $user->nombre . '</td>';
            echo '<td>' . $user->getTypeString($user->tipo) . '</td>';
            echo '<td>' . $user->poblacion . '</td>';
            echo '<td>' . $user->direccion . '</td>';
            echo '<td><a href="index.php?edit=' . $user->id . '" target="_self"><img src="view/img/edit_element.png" alt="edit" /></a></td>';
            echo '<td><a href="index.php?delete=' . $user->id . '" target="_self"><img src="view/img/delete_element.png" alt="delete" /></a></td></tr>';
        }
        echo '</tbody></table></div>';
    }

    public function deleteUser($id) {
        echo '<div class="cuerpo negrita" style="text-align: center;">
                    <p>¿Está seguro de que quiere borrar el usuario seleccionado? Usuario ID: <span class="negrita">' . $id . '</span></p>
                    <form action="index.php" method="post">
                        <input class="botonBorrar" type="submit" name="deleteConfirm" value="Borrar" />
                        <input type="hidden" name="userID" value="' . $id . '" />
                    </form>
                    <form action="index.php" method="post">
                        <input class="botonCancelar" type="submit" name="cancel" value="Cancelar" />
                    </form>
                </div>';
    }

    public function editUser($id) {
        $control = new UserControl();
        $user = $control->getUserByID($id);
        echo '<div class="cuerpo">
                <p>Editar usuario</p>
                <form action="index.php" method="post" name="editUserForm" id="editUserForm">
                    <table class="tabla">
                        <thead>
                            <th><span class="negrita">Campo</span></th>
                            <th><span class="negrita">Valor</span></th>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="negrita">ID</span></td>
                                <td>' . $user->id . '</td>
                            </tr>
                            <tr>
                                <td><span class="negrita">Usuario</span></td>
                                <td>' . $user->usuario . '</td>
                            </tr>
                            <tr>
                                <td><span class="negrita">Contraseña</span></td>
                                <td>
                                    <input type="password" id="passwd" name="editPassword" placeholder="Escribir para modificar" />
                                    <span id="passdiv" style="display: none;"></span>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="negrita">Nombre</span></td>
                                <td>
                                    <input type="text" id="nombre" name="editNombre" value="' . $user->nombre . '" />
                                    <span id="nombrediv" style="display: none;"></span>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="negrita">Tipo</span></td>
                                <td>
                                    <select name="editTipo" id="tipoUsuario" onchange="showOrHideAdress();">';
                                    for ($i = 1; $i < 4; $i++) {
                                        echo '<option value="' . $i . '"' . ($i == $user->tipo ? "selected" : ""). '>' . $user->getTypeString($i) . '</option>';
                                    }
        echo                        '</select></td>
                            </tr>
                            <tr id="poblacion">
                                <td><span class="negrita">Población</span></td>
                                <td>
                                    <input type="text" name="editPoblacion" id="pobla" value="' . $user->poblacion . '" />
                                    <span id="pobladiv" style="display: none;"></span>
                                </td>
                            </tr>
                            <tr id="direccion">
                                <td><span class="negrita">Dirección</span></td>
                                <td>
                                    <input type="text" name="editDireccion" id="direc" value="' . $user->direccion . '" />
                                    <span id="direcdiv" style="display: none;"></span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <input type="hidden" name="editID" value="' . $user->id . '" />
                    <input type="hidden" name="editUser" />
                    <input type="button" value="Editar" onClick="checkEditUser();" />
                </form>
            </div>';
    }

    public function createUserForm() {
        echo '<div class="cuerpo">
                <p>Registro de usuario</p>
                <form action="index.php" method="post" name="createUserForm" id="createUserForm">
                    <table class="tabla">
                        <thead>
                            <th><span class="negrita">Campo</span></th>
                            <th><span class="negrita">Valor</span></th>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="negrita">Usuario</span></td>
                                <td>
                                    <input type="text" id="username" name="newUsername" />
                                    <span id="usernamediv" style="display: none;"></span>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="negrita">Contraseña</span></td>
                                <td>
                                    <input type="password" id="passwd" name="newPassword" />
                                    <span id="passdiv" style="display: none;"></span>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="negrita">Nombre</span></td>
                                <td>
                                    <input type="text" id="nombre" name="newNombre" />
                                    <span id="nombrediv" style="display: none;"></span>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="negrita">Tipo</span></td>
                                <td>
                                    <select name="newTipo" id="tipoUsuario" onchange="showOrHideAdress();">
                                        <option value="1">Administrador</option>
                                        <option value="2" selected>Cliente</option>
                                        <option value="3">Repartidor</option>
                                    </select>
                                </td>
                            </tr>
                            <tr id="poblacion">
                                <td><span class="negrita">Población</span></td>
                                <td><input type="text" id="pobla" name="newPoblacion" />
                                    <span id="pobladiv" style="display: none;"></span>
                                </td>
                            </tr>
                            <tr id="direccion">
                                <td><span class="negrita">Dirección</span></td>
                                <td>
                                    <input type="text" id="direc" name="newDireccion" />
                                    <span id="direcdiv" style="display: none;"></span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <input type="hidden" name="newUser" />
                    <input type="button" value="Registrar" onClick="checkNewUser();" />
                </form>
            </div>';
    }
}
