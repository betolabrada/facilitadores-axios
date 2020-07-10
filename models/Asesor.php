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

  // Get asesor de grupo
  public function getAsesorDeGrupo($idGrupo) {
    $sql = 'SELECT 
        grup.grupo, a.nombre, e.nombre as nombreEscuela, t.tipo, t.descripcion, e.numero, l.nombre as sede
        FROM Grupo grup 
        JOIN Grado grad on grad.idGrado = grup.idGrado 
        JOIN Turno t on t.idTurno = grad.idTurno 
        JOIN Asesor a on a.idAsesor = t.idAsesor 
        JOIN Escuela e on e.idEscuela = t.idEscuela
        JOIN Localidad l on l.idLocalidad = e.idLocalidad
        WHERE idGrupo = :idGrupo';

    $this->db->query($sql);

    $this->db->bind(':idGrupo', $idGrupo);

    return $this->db->single();
  }

  // INSERT INTO Asesor (idAsesor, nombre, correo, `password`)
  public function insertarAsesor($nombre, $correo, $contra) {
    $this->db->query("INSERT INTO Asesor (nombre, correo, `password`)
      VAUES (:nombre, :correo, PASSWORD(:contra))");
    
    $this->db->bind(':nombre', $nombre);
    $this->db->bind(':correo', $correo);
    $this->db->bind(':contra', $contra);

    return $this->db->execute();
  }
}