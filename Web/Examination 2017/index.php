<?php
include_once 'lib.php';
View::start('Distribuidora');
View::navigation();


$res = DB::execute_sql('SELECT * FROM usuarios;');
$res->setFetchMode(PDO::FETCH_NAMED);

echo '<div class="centro"><img src="logo.png" alt="Logo de la empresa" /></div>';
echo '<h2>Ejemplo acceso a tabla</h2>';
echo "<table class='tabla'>\n";
echo "<tr class='cabecera'><th>Cuenta</th><th>Nombre</th></tr>\n";
$i = 0;
foreach($res->fetchAll() as $usuario){
    echo "<tr class='" . ($i % 2 == 0 ? "par":"impar") . "'>";
    echo "<td>${usuario['usuario']}</td>";
    echo "<td>${usuario['nombre']}</td>";
    echo "</tr>\n";
    $i++;
}
echo "</table>\n";
View::end();
