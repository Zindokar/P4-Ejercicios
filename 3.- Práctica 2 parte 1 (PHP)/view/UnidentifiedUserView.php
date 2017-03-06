<?php
class UnidentifiedUserView {
    public static function signInForm() {
        echo '
            <div class="loginForm">
                <span class="titulito negrita">Identificación</span>
                <form action="index.php" method="post">
                    <table>
                        <tr>
                            <td><span class="negrita">Usuario</span></td>
                            <td><input type="text" placeholder="Usuario" name="userLogin" /></td>
                        </tr>
                        <tr>
                            <td><span class="negrita">Contraseña</span></td>
                            <td><input type="password" placeholder="Contraseña" name="passLogin" /></td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="submit" name="login" value="Login" /></td>
                        </tr>
                    </table>
                </form>
            </div>
        ';
    }
}
