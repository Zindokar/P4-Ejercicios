<?php
include_once 'lib.php';
$error='';
if(isset($_POST['usuario']) && isset($_POST['clave'])){
    if(User::login($_POST['usuario'],$_POST['clave'])){
        header('Location:index.php');
        die;
    }
    $error='<h3>Error en el login. Inténtelo de nuevo</h3>';
}
View::start('login');
View::navigation();
echo $error;
echo '<div class="centro"><img src="logo.png" alt="Logo de la empresa" /></div>';
echo '<h2>Login - Acceso</h2>';
echo '<form method="post">';
echo "<div class='centro'><table>
        <tr>
            <td class='par'>Usuario</td>
            <td class='impar'><input type='text' name='usuario'></td>
        </tr>
        <tr>
            <td class='impar'>Clave</td>
            <td class='par'><input type='password' name='clave'><td>
        </tr>
        <tr class='cabecera'>
            <td colspan='2'><input type='submit' value='Entrar'></td>
        </tr>
        </table></div>";
echo '</form>';
View::end();
