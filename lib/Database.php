<?php
class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $conn;
    private $error;
    private $stmt;

    public function __construct() {
        $this->conn = new mysqli($servername, $username, $password, $dbname) or 
            die("Conexión fallida: " . $this->conn->connect_error);
        
    }

    public function query($query) {
        $this->stmt = $this->conn->prepare($query);
    }

    public function bind($types, ...$params) {
    
        $this->stmt->bind_param($types, $params);
    }

    public function execute() {
        return $this->stmt->execute();
    }

    public function resultSet() {
        $this->execute();
        return $this->stmt->fetch_all(MYSQLI_ASSOC);
    }

    public function resultSingle() {
        $this->execute();
        return $this->stmt->fetch(MYSQLI_ASSOC);
    }

}