<?php
include_once 'lib.php';
View::start('Distribuidora');
View::navigation();
$msg = "";
$color = "";

// mando de editar bebida aquí para que una vez editado aparezca el listado de bebida y se vea su bebida editada
if (isset($_POST['editarBebida'])) { 
    try {
        $id = $_POST['bebidaID'];
        $marca = $_POST['bebidaMarca'];
        $stock = $_POST['bebidaStock'];
        $pvp = $_POST['bebidaPVP'];
        // comprobacion por php de los campos
        if (strlen($marca) >= 2 && intval($stock) >= 0 && floatval($pvp) >= 0) {
            $res = DB::execute_sql('UPDATE bebidas SET marca = ?, stock = ?, PVP = ? WHERE id = ?;',
                                    array($marca, $stock, $pvp, $id));
            $msg = "Bebida editada";
            $color = "bien";
        } else {
            $msg = "Los campos deben ser coherentes";
            $color = "mal";
        }
    } catch (Exception $e) {
        $msg = $e->getMessage();
        $color = "mal";
    }
}


$res = DB::execute_sql('SELECT * FROM bebidas;');
$res->setFetchMode(PDO::FETCH_NAMED);

echo '<div class="centro"><img src="logo.png" alt="Logo de la empresa" /></div>';

if ($msg != "") { // muestro mensaje de error o de suceso
    echo "<div id='mensajePHP' class='" . $color . "'>" . $msg . "</div>";
}

echo "<div style='display: none;' class='' id='ajaxResponse'></div>";

// lista de bebidas
echo '<h2>Lista de bebidas</h2>';
echo '<table class="tabla"><thead>
        <tr class="cabecera">
            <th>ID</th>
            <th>Marca</th>
            <th>Stock</th>
            <th>PVP</th>
            <th>Editar</th>
            <th>Borrar</th>
        </tr></thead><tbody>';
$i = 0;
foreach ($res->fetchAll() as $bebida) {
    echo '<tr id="fila' . $bebida['id'] . '" class="' . ($i % 2 == 0 ? "par":"impar") . '">
            <td>' . $bebida['id'] . '</td>
            <td>' . $bebida['marca'] . '</td>
            <td>' . $bebida['stock'] . '</td>
            <td>' . $bebida['PVP'] . '</td>
            <td><a href="editar_bebida.php?id=' . $bebida['id'] . '">Editar</a></td>
            <td><input type="button" value="Borrar" onclick="borrarBebida(\'' . $bebida['id'] . '\')" /></td>
        </tr>';
    $i++;
}
echo '</tbody></table>';
echo "\n";
View::end();