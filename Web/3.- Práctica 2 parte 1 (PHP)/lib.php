<?php
class View{
    public static function start(){
        User::session_start();
        echo '<h1 class="titulo">Distribuidora Krypto</h1>';
    }
    public static function menu() {
        echo '<div class="cabecera">
                <ul class="menu">
                    <li class="menuItem"><a href="index.html">Inicio</a></li>
                    <li class="menuItem"><a href="tabla.html">Productos</a></li>
                    <li class="menuItem"><a href="contacto.html">Contacto</a></li>
                </ul>
            </div>';
    }
    public static function navigation(){
        echo '<nav>';
        echo '</nav>';
    }
    public static function end(){
        echo '<div class="pie">Copyright &copy; 2015-2025 Distribuidoras Krypro</div>';
    }
}

class DB{
    private static $connection=null;
    public static function get(){
        if(self::$connection === null){
            self::$connection = $db = new PDO("sqlite:./datos.db");
            self::$connection->exec('PRAGMA foreign_keys = ON;');
            self::$connection->exec('PRAGMA encoding="UTF-8";');
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$connection;
    }
    public static function execute_sql($sql,$parms=null) {
        try {
            $db = self::get();
            $ints= $db->prepare ( $sql );
            if ($ints->execute($parms)) {
                return $ints;
            }
        }
        catch (PDOException $e) {
            echo '<h3>Error en al DB: ' . $e->getMessage() . '</h3>';
        }
        return false;
    }
}
class User{
    public static function session_start() {
        if(session_status () === PHP_SESSION_NONE){
            session_start();
        }
    }
    public static function getLoggedUser(){ //Devuelve un array con los datos del cuenta o false
        self::session_start();
        if(!isset($_SESSION['user'])) return false;
        return $_SESSION['user'];
    }
    public static function login($usuario,$pass){ //Devuelve verdadero o falso según
        self::session_start();
        $db=DB::get();
        $inst=$db->prepare('SELECT * FROM usuarios WHERE usuario=? and clave=?');
        $inst->execute(array($usuario,md5($pass)));
        $inst->setFetchMode(PDO::FETCH_NAMED);
        $res=$inst->fetchAll();
        if(count($res)==1){
            $_SESSION['user']=$res[0]; //Almacena datos del usuario en la sesión
            return true;
        }
        return false;
    }
    public static function logout(){
        self::session_start();
        unset($_SESSION['user']);
    }
}
