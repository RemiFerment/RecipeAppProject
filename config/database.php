<?php
require_once "../private/private.php";
class Database
{
    //
    private static $pdo = null;

    public static function getConnection(): PDO|null
    {
        //
        $host = "127.0.0.1";
        $port = "3306";
        $dbname = "RecipeApp";
        $charset = "utf8mb4";
        $user = "root";
        $password = ROOT_PASSWORD;

        $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=$charset";

        if (self::$pdo == null) {
            try {
                self::$pdo = new PDO($dsn, $user, $password);
                return self::$pdo;
            } catch (PDOException $e) {
                $messageError = $e->getMessage();
                throw new Exception("Unable to connect at the database, check database Name, Username, password. Server down ? $messageError", 1001);

                Helpers::ErrorFlash("Impossible de se connecter à la base donnée !", "login");
                return null;
            }
        } else {
            return self::$pdo;
        }
    }
}
