<?php

class Escuela {
    private $db;

    public function __construct() {
      $this->db = new Database();
    }

    public function addMotivo($motivo, $tipoAsesoria) {
        $query = 'INSERT INTO Motivo (idMotivo, motivo, idTipoAsesoria) '
                . 'values (null, :motivo, :idTipoAse)';
        
        $this->db->query($query);
        
        $this->db->bind(':motivo', $motivo);
        $this->db->bind(':idTipoAse', $tipoAsesoria);
        
        if ($this->db->execute()) {
            return true;
        }
        return false;
    }
}