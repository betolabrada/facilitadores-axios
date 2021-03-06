<?php

  class Escuela {
    private $db;

    public function __construct() {
      $this->db = new Database();
    }

    // Get all escuelas
    public function getEscuelas($idLocalidad = "") {
      $sql = 'SELECT * FROM Escuela';

      if (!empty($sede)) {
        $sql .= ' WHERE idLocalidad = :idLocalidad';
      }
      $this->db->query($sql);

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
        $query = 'INSERT INTO Localidad (nombre) VALUES (:ciudad)';
        
        $this->db->query($query);
        
        $this->db->bind(':ciudad', $ciudad);
        
        if ($this->db->execute()) {
            return true;
        }
        return false;
    }
    
    // Insert escuela
    public function insertEscuela($data){

        $query = 'INSERT INTO Escuela (nombre, numero, turno, idLocalidad) '
                . 'VALUES (:nombre, :numero, :turno, :localidad)';
        
        $this->db->query($query);
        
        $this->db->bind(':nombre', $data['nombre']);
        $this->db->bind(':numero', $data['numero']);
        $this->db->bind(':turno', $data['turno']);
        $this->db->bind(':localidad', $data['localidad']);
        
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
    public function deleteEscuela($idEscuela){
        $this->db->query('DELETE FROM Escuela WHERE idEscuela = :idEscuela');
        
        // Bind value
        $this->db->bind(':idEscuela', $idEscuela);
        
        // Execute
        if ($this->db->execute()) {
            return true;
        }
        return false;
        
    }
    
  }