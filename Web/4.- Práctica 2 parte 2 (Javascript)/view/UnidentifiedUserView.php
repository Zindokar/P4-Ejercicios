<?php
class UnidentifiedUserView {
    public function signInForm() {
        echo '
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
                        </tr>
                    </table>
                </form>
            </div>
        ';
    }
}
