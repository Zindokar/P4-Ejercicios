<?php
class UnidentifiedUserView {
    public function signInForm() {
        echo '
<<<<<<< HEAD
            <div class="incorrecto" id="message" style="display: none;"></div>
            <div class="loginForm">
                <span class="titulito negrita">Identificación</span>
                <form action="index.php" method="post" name="loginForm" id="loginForm">
                    <table>
                        <tr>
                            <td><span class="negrita">Usuario</span></td>
                            <td><input type="text" placeholder="Usuario" name="userLogin" id="userLogin" /></td>
                        </tr>
                        <tr>
                            <td><span class="negrita">Contraseña</span></td>
                            <td><input type="password" placeholder="Contraseña" name="passLogin" id="passLogin" /></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="button" value="Login" onclick="checkLogin();" />
                                <input type="hidden" name="login" />
                            </td>
=======
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
>>>>>>> origin/master
                        </tr>
                    </table>
                </form>
            </div>
        ';
    }
}
