<?php

class Database {
    private static $host = 'localhost';
    private static $db_name = 'avaliacao3';
    private static $username = 'avaliacao_user';
    private static $password = '123456';
    private static $conn;

    public static function getConnection() {
        self::$conn = null;

        try {
            self::$conn = new PDO("mysql:host=" . self::$host . ";dbname=" . self::$db_name, self::$username, self::$password);
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $exception) {
            echo "Erro na conexão com o banco de dados: " . $exception->getMessage();
            exit;
        }

        return self::$conn;
    }
}