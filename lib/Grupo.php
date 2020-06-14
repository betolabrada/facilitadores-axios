<?php
class Grupo {
    private $conn;
    private $grupoId;
    private $grupo;
    private $gradoId;

    public function __construct() {
        $this->conn = new Database();
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
        
        $result = $this->conn->query($sql) or die($this->conn->error);
        return $result;
    }
}