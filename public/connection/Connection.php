<?php
class ConnectionFactory {
    static $connection;

    public static function getConnection() {
        if (!isset(self::$connection)) {
            $host = "localhost";
            $dbName = "sps";
            $user = "root";
            $pass = "";
            $port = 3306;

            try {
                self::$connection = new PDO("mysql:host=$host;dbname=$dbName;port=$port", $user, $pass);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return self::$connection;
            } catch (PDOException $ex) {
                echo "ERRO ao conectar no banco de dados! <p>$ex</p>";
                return null; 
            }
        }

        return self::$connection; 
    }
}
?>
