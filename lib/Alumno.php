<?php
// instance of lista
class Alumno {
    private $conn;
    private $escuela;
    private $turno;
    private $grado;
    private $grupo;

    public function __construct() {
        $this->conn = new mysqli("localhost", "root", "", "axios") or 
            die("Conexión fallida: " . $this->conn->connect_error);
    }

    // Get all alumnos
    public function getAllAlumnos($grupoId) {
        $sql = "SELECT * FROM Alumno WHERE idGrupo = " . $grupoId . " ORDER BY idAlumno";
        $result = $this->conn->query($sql) or die($this->conn->error);

        return $result;
    }
}