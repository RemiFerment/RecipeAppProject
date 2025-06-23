<?php

class Database{
    //
    private static $pdo = null;

    public static function getConnection():PDO|null{
        //
        $host = "127.0.0.1";
        $port = "3306";
        $dbname = "RecipeApp";
        $charset = "utf8mb4";
        $user="root";
        $password="";
        
        $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=$charset";
        
        if(self::$pdo == null){
            try{
                echo "<h3>Connexion à la base de donnée réussi !</h3>";
                return self::$pdo = new PDO($dsn,$user,$password);
            } catch (PDOException $e){
                //Journalisation à faire
                echo "<h3>Impossible de se connecter à la base donnée !</h3>";
                return null;
            }
            } else {
                return self::$pdo;
            }
            
    }
}