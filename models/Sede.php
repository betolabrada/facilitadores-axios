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

    // @method    DELETE  
    // @desc      borrar sede pasando su id
    public function removeSede($idSede) {
      $this->db->query('DELETE FROM Localidad 
        WHERE idLocalidad = :idLocalidad');

      $this->db->bind(':idLocalidad', $idSede);

      if ($this->db->execute()) {
        return true;
      }
      return false;
    }


    public function getEscuelaLocalidad($idLocalidad = '') {
      $sql = "SELECT 
        Escuela.nombre as Escuela,
        Escuela.idEscuela as idEscuela,
        Escuela.idLocalidad as idSede, 
        Localidad.nombre as Sede
        FROM Escuela 
        LEFT JOIN Localidad on Escuela.idLocalidad = Localidad.idLocalidad";
      
      if (!empty($idLocalidad)) {
        $sql .= " WHERE Escuela.idLocalidad = :idLocalidad";
      }
      $sql .= " ORDER BY Escuela.nombre ASC";

      $this->db->query($sql);
      if (!empty($idLocalidad)) {
        $this->db->bind(':idLocalidad', $idLocalidad);
      }

      return $this->db->resultSet();
    }

  }