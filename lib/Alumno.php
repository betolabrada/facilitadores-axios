<?php
class Alumno {
    private $conn;
    private $escuela;
    private $turno;
    private $grado;
    private $grupo;

    public function __construct() {
        $this->conn = new Database;
    }

    // Get all alumnos
    public function getAllAlumnos() {
        $this->conn->query("SELECT * FROM Alumno");

        $results = $this->conn->resultSet();
    }

    // Get grupoId
    public function getGroupId
}