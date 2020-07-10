<?php

  class Sede {
    private $db;

    public function __construct() {
      $this->db = new Database();
    }

    public function getSedes() {
      $this->db->query('SELECT * FROM Localidad');

      return $this->db->resultSet();
    }

    public function getSede($idSede) {
      $this->db->query('SELECT * FROM Localidad WHERE idLocalidad = :idLocalidad');

      $this->db->bind(':idLocalidad', $idSede);

      return $this->db->single();
    }

    public function updateSede($idSede, $nombre) {
      $this->db->query('UPDATE Localidad 
      SET nombre = :nombre 
      WHERE idLocalidad = :idLocalidad');

      $this->db->bind(':idLocalidad', $idSede);
      $this->db->bind(':nombre', $nombre);

      if ($this->db->execute()) {
        return true;
      }
      return false;
    }


    public function getEscuelaLocalidad() {
      $sql = "SELECT 
      Escuela.nombre as Escuela,
      Escuela.idEscuela as idEscuela,
      Escuela.idLocalidad as idSede, 
      Localidad.nombre as Sede
      FROM Escuela 
      JOIN Localidad on Escuela.idLocalidad = Localidad.idLocalidad
      ORDER BY Escuela.nombre ASC";

      $this->db->query($sql);

      return $this->db->resultSet();
    }

  }