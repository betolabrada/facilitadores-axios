<?php
// instance of db
class Database {
    private $conn;

    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $error;
    private $stmt;

    public function __construct() {
        $this->conn = new mysqli("localhost", "root", "", "axios") or 
            die("Conexión fallida: " . $this->conn->connect_error);
    }

    public function query($query) {

        return $this->conn->query($query);
    }

    // Get all alumnos
    public function getAllAlumnos($grupoId) {
        $sql = "SELECT * FROM Alumno WHERE idGrupo = " . $grupoId . " ORDER BY idAlumno";
        $result = $this->conn->query($sql) or die($this->conn->error);

        return $result;
    }

    // Get escuela name by id
    public function getEscuela($idEscuela) {
        $sql = "SELECT nombre FROM Escuela WHERE idEscuela = $idEscuela";
        $result = $this->conn->query($sql) or die($this->conn->error);
        return $result->fetch_assoc()['nombre'];
    }

    

    public function getGradoId($pEscuela, $pTurno, $pGrado) {
        $sql = "SELECT idGrado FROM Grado
            JOIN Turno ON Grado.idTurno = Turno.idTurno
            JOIN Escuela ON Turno.idEscuela = Escuela.idEscuela
            WHERE Grado.numero = $pGrado 
            AND Turno.tipo = '$pTurno'
            AND Escuela.nombre = $pEscuela
        ";



    }

    public function close() {
        $this->conn->close();
    }
}