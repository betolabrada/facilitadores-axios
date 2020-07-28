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
    
}