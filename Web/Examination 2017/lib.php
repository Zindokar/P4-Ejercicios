<?php
class View{
    public static function  start($title){
        $html = "<!DOCTYPE html>
<html>
<head>
<meta charset=\"utf-8\">
<link rel=\"stylesheet\" type=\"text/css\" href=\"estilos.css\">
<script src=\"scripts.js\"></script>
<script src=\"https://code.jquery.com/jquery-1.12.4.min.js\"></script>
<title>$title</title>
</head>
<body><div class='cuerpo'>";
        User::session_start();
        echo $html;
    }
    public static function navigation(){
        $user = User::getLoggedUser();
        echo '<nav class="navegacion">';
        if($user === false){
            echo '<a href="login.php">Login</a> ';
            echo '<a href="a.php">BD</a> ';
        }else{
            switch($user['tipo']){
                case 1: //adm
                    echo '<a href="listar_bebidas.php">Listar bebidas</a> ';
                    break;
                    
                case 2:
                    break;
                    
                case 3:
                    break;
                    
                default:
                    break;
            }
            echo '<a href="a.php">BD</a> ';
            echo '<a href="logout.php">Logout</a> ';
            echo 'Usuario: '.$user['nombre'];
        }
        echo '</nav>';
    }
    public static function end(){
        echo '</div></body>
</html>';
    }
}

class DB{
    private static $connection=null;
    public static function get(){
        if(self::$connection === null){
            $PATH = $_SERVER['DOCUMENT_ROOT'];
            self::$connection = $db = new PDO("sqlite:$PATH/datos.db");
            self::$connection->exec('PRAGMA foreign_keys = ON;');
            self::$connection->exec('PRAGMA encoding="UTF-8";');
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$connection;
    }
    public static function execute_sql($sql,$parms=null){
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
        return $false;
    }
    
    public static function execute_sql_throwsException($sql,$parms=null){
        $db = self::get();
        $ints= $db->prepare ( $sql );
        if ($ints->execute($parms)) {
            return $ints;
        }
        return $false;
    }
}
class User{
    public static function session_start(){
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
