<?php
// instance of db
class Database {
    private $conn;

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

    // Get information about student group
    public function getDatos($pEscuela, $pTurno, $pGrado, $pGrupo) {
        $sql = "SELECT 
              grup.grupo
              , a.nombre
              , e.nombre as nombreEscuela
              , t.tipo
              , t.descripcion
              , e.numero
              , l.nombre as sede
            FROM Grupo grup 
              JOIN Grado grad on grad.idGrado = grup.idGrado 
              JOIN Turno t on t.idTurno = grad.idTurno 
              JOIN Asesor a on a.idAsesor = t.idAsesor 
              JOIN Escuela e on e.idEscuela = t.idEscuela
              JOIN Localidad l on l.idLocalidad = e.idLocalidad
            WHERE e.idEscuela = '$pEscuela'
            AND t.descripcion = '$pTurno'
            AND grad.numero = '$pGrado'
            AND grup.grupo LIKE '_$pGrupo%' " ;
        
        $result = $this->conn->query($sql) or die($GLOBALS['conn']->error);
        return $result;
    }

    public function close() {
        $this->conn->close();
    }
}