<?php
class Database {
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
        try {
            $this->pdo = new PDO('mysql:host=localhost;dbname=test', 'root', 'root');
            echo 'ok';
        } catch (PDOException $exception) {
            dir($exception->getMessage());
        }
    }
    public static function getInstance() {
        if (!isset(self::$instance)){
            self::$instance = new Database();
        }
        return self::$instance;
    }
}