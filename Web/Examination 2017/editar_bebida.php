<?php
include_once 'lib.php';
View::start('Distribuidora');
View::navigation();
echo '<div class="centro"><img src="logo.png" alt="Logo de la empresa" /></div>';
echo '<h2>Editar de bebida</h2>';

if (isset($_GET['id'])) {
    $res = DB::execute_sql('SELECT * FROM bebidas WHERE id = ?;', array($_GET['id']));
    $res->setFetchMode(PDO::FETCH_NAMED);
    $bebida = $res->fetch();
    echo "<div id='errorEditar' class='mal' style='display: none;'></div>";
    echo "<form action='listar_bebidas.php' method='post' name='editarBebidaForm' id='editarBebidaForm'><table class='tabla'>
            <tr>
                <td class='par'>ID</td>
                <td class='impar'>
                    " . $bebida['id'] . "
                    <input type='hidden' name='bebidaID' value='" . $bebida['id'] . "' />
                </td>
            </tr>
            <tr>
                <td class='impar'>Marca</td>
                <td class='par'><input type='text' name='bebidaMarca' id='bebidaMarca' value='" . $bebida['marca'] . "' /></td>
            </tr>
            <tr>
                <td class='par'>Stock</td>
                <td class='impar'><input type='text' name='bebidaStock' id='bebidaStock' value='" . $bebida['stock'] . "' /></td>
            </tr>
            <tr>
                <td class='impar'>PVP</td>
                <td class='par'><input type='text' name='bebidaPVP' id='bebidaPVP' value='" . $bebida['PVP'] . "' /></td>
            </tr>
            <tr class='cabecera'>
                <td colspan='2'><input type='button' value='Editar' onclick='comprobarEditarBebida();' /></td>
            </tr>
    </table>
        <input type='hidden' name='editarBebida' />
    </form>";
} else {;
    echo '<h2>Error, debe acceder desde el listado de bebidas.</h2>';
}

View::end();