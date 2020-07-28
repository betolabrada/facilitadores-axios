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
    
    // Insert localidad
    public function insertLocalidad($ciudad){
        $query = 'INSERT INTO Localidad (idLocalidad, nombre) VALUES (null, :ciudad)';
        
        $this->db->query($query);
        
        $this->db->bind(':ciudad', $ciudad);
        
        if ($this->db->execute()) {
            return true;
        }
        return false;
    }
    
    // Insert escuela
    public function insertEscuela($nombre,$numero,$turno,$localidad){
        $query = 'INSERT INTO Escuela (idEscuela, nombre, numero, turno, idLocalidad) '
                . 'VALUES (null, :nombreEsc, :numeroEsc, :turnoEsc, :idLoc)';
        
        $this->db->query($query);
        
        $this->db->bind(':nombreEsc', $nombre);
        $this->db->bind(':numeroEsc', $numero);
        $this->db->bind(':turnoEsc', $turno);
        $this->db->bind(':idLoc', $localidad);
        
        if ($this->db->execute()) {
            return true;
        }
        return false;
    }
    
    // Single update escuela
    public function singleUpdateEscuela($variable,$variableCambiar,$nombreEscuela){
        $query = 'UPDATE Escuela 
	SET :variable = :variableCambiar
	WHERE nombre = :nombreEscuela';
        
        $this->db->query($query);
        
        $this->db->bind(':variable', $variable);
        $this->db->bind(':variableCambiar', $variableCambiar);
        $this->db->bind(':nombreEscuela', $nombreEscuela);
        
        if ($this->db->execute()) {
            return true;
        }
        return false;
    }
    
    // Delete escuela
    public function deleteEscuela($nombreEscuela){
        $this->db->query('DELETE FROM Escuela WHERE nombre = :nombreEscuela');
        
        // Bind value
        $this->db->bind(':nombreEscuela', $nombreEscuela);
        
        // Execute
        if ($this->db->execute()) {
            return true;
        }
        return false;
        
    }
    
  }