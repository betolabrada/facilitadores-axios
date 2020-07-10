<?php

  class Escuela {
    private $db;

    public function __construct() {
      $this->db = new Database();
    }

    // Get all escuelas
    public function getEscuelas() {
      $this->db->query('SELECT * FROM Escuela');

      $results = $this->db->resultSet();

      return $results;
    }

    // Get escuela name by id
    public function getEscuela($idEscuela) {
      $this->db->query('SELECT * FROM Escuela WHERE idEscuela = :idEscuela');

      // Bind value
      $this->db->bind(':idEscuela', $idEscuela);

      // Execute
      return $this->db->single();
      
    }


    // Update escuela 
    public function updateEscuela($idEscuela, $nombre, $numero, $turno, $idLocalidad) {
      $this->db->query('UPDATE Escuela 
      SET nombre= :nombre, 
        numero = :numero, 
        turno = :turno, 
        idLocalidad= :idLocalidad 
      WHERE idEscuela = :idEscuela');

      // Bind value
      $this->db->bind(':idEscuela', $idEscuela);
      $this->db->bind(':nombre', $nombre);
      $this->db->bind(':numero', $numero);
      $this->db->bind(':turno', $turno);
      $this->db->bind(':idLocalidad', $idLocalidad);

      // Execute
      if ($this->db->execute()) {
        return true;
      }
      return false;
      
    }
  }