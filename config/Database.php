<?php

require_once __DIR__ . '/Messages.php';

class Database {
    private $host;
    private $database;
    private $username;
    private $password;
    private $connection;

    public function __construct($host, $database, $username, $password) {
        $this->host = $host;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
    }

    public function connect() {
        try {
            $this->connection = new PDO("mysql:host={$this->host};dbname={$this->database}", $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch (PDOException $e) {
            die(Messages::DB_CONNECTION_FAILED . ": " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->connection;
    }
}