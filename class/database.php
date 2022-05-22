<?php

require_once('config.php');

class Database {
    private static $pdo;
    
    public static function instantiate() {
        if(!isset(self::$pdo)) {
            try {
                self::$pdo = new PDO('mysql:host='.SERVER.';dbname='.DB, USER, PASSWORD);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            } catch (\PDOException $error) {
                echo "Falha ao se conectar ao banco de dados: ". $error->getMessage();            
            }
        }

        return self::$pdo;
    }

    public static function queryPrepare($sql) {
        return self::instantiate()->prepare($sql);
    }
}