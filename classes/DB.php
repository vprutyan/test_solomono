<?php

class DB {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        $configConnection = Config::getConfig('database');
        $host = $configConnection['db_host'] ?? 'localhost';
        $db   = $configConnection['db_name'] ?? 'db';
        $user = $configConnection['db_user'] ?? 'root';
        $pass = $configConnection['db_pass'] ?? 'root';
        $charset = $configConnection['db_charset'] ?? 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $this->pdo = new \PDO($dsn, $user, $pass, $options);
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new DB();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->pdo;
    }
}