<?php

class Turno {
    private $db;

    public function __construct() {
      $this->db = new Database();
    }

    // Agregar turno
    public function agregarTurno($tipo, $descripcion, $escuela, $asesor) {
        $query = 'INSERT INTO Turno (idTurno, tipo, descripcion, idEscuela, idAsesor) 
            VALUE (null, :tipo, :descripcion, :idEsc, :idAse)';
        
        $this->db->query($query);
        
        $this->db->bind(':tipo', $tipo);
        $this->db->bind(':descripcioen', $descripcion);
        $this->db->bind(':idEsc', $escuela);
        $this->db->bind(':idAse', $asesor);
        
        if ($this->db->execute()) {
            return true;
        }
        return false;
    }
    
    public function updateTurno($idAsesor,$idTurno) {
        $query = 'Update Turno
	SET idAsesor = :idAsesor
	WHERE idTurno = :idTurno';
        
        $this->db->query($query);
        
        $this->db->bind('idAsesor', $idAsesor);
        $this->db->bind('idTurno', $idTurno);
        
        if ($this->db->execute()) {
            return true;
        }
        return false;
    }
    
     public function getTurnos() {
        $this->db->query('SELECT Turno.idTurno, Turno.tipo, Escuela.nombre as Escuela, '
                . 'Asesor.nombre FROM Turno JOIN Escuela ON Turno.idEscuela = '
                . 'Escuela.idEscuela JOIN Asesor ON Asesor.idAsesor = Turno.idAsesor');

        $results = $this->db->resultSet();

        return $results;
    }
    
}