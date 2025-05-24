<?php
class ConnectionFactory{
    static $connection;

    public static function getConnection(){
        if(!isset(self::$connection)){
            $host = "localhost";
            $dbName = "teste";
            $user = "root";
            $pass = "";
            $port = 3306; 
            try{
                self::$connection = new PDO("mysql:host=$host;dbname=$dbName;port=$port",$user,$pass);
            }catch(PDOException $ex){
                echo("ERRO ao conectar no banco de dados! <p>$ex</p>");
            }
        }
        return self::$connection;
    }
}
?>