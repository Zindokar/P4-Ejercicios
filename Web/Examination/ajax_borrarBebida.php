<?php
include_once 'lib.php';
$id = (isset($_POST['bebidaID']) ? $_POST['bebidaID'] : 'error');

if (strcmp($id, "error") == 0) {
    $result = ['mensaje' => "Error al capturar la bebida", 'borrado' => false];
} else {
    // eliminar bebida
    try {
        $res = DB::execute_sql_throwsException('DELETE FROM bebidas WHERE id = ?;', array($id));
        $result = ['mensaje' => "Bebida borrada correctamente", 'borrado' => true];
    } catch (Exception $e) {
        $msg = $e->getMessage();
        $result = ['mensaje' => $msg, 'borrado' => false];
    }
}

echo json_encode($result);