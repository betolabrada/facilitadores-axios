<?php

class Asesor {
  private $db;

  public function __construct() {
    $this->db = new Database();
  }

  public function login($email, $pass) {

    $this->db->query('SELECT * FROM Asesor WHERE correo = :correo AND `password` = PASSWORD(:pass)');

    // Bind params
    $this->db->bind(':correo', $email);
    $this->db->bind(':pass', $pass);

    // Execute
    return $this->db->single();
  }

  public function getAsesores() {
    $this->db->query("SELECT * FROM Asesor WHERE correo NOT LIKE 'admin%'");
    
    return $this->db->resultSet();
  }

  // @method  SELECT
  // @desc    GET Asesor by email
  // @fields  *.Asesor 
  public function getAsesorByEmail($email) {
    $this->db->query('SELECT * FROM Asesor WHERE correo = :email');

    $this->db->bind(':email', $email);

    return $this->db->single();
  }

  // @method  SELECT
  // @desc    GET Asesor by its id
  // @fields  *.Asesor 
  public function getAsesorById($idAsesor) {
    $this->db->query('SELECT * FROM Asesor WHERE idAsesor = :idAsesor');

    $this->db->bind(':idAsesor', $idAsesor);

    return $this->db->single();
  }
}