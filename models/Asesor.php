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

  // @method  SELECT
  // @desc    GET Asesor from grupo (id)
  // @fields  grupo, nombre, nombreEscuela, tipoTurno, descTurno, numeroEscuela, sede 
  public function getAsesorDeGrupo($idGrupo) {
    $sql = 'SELECT 
        grup.grupo, a.nombre, e.nombre as nombreEscuela, t.tipo, t.tipo, e.numero, l.nombre as sede
        FROM Grupo grup 
        JOIN Turno t on t.idTurno = grup.idTurno 
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
      VALUES (:nombre, :correo, PASSWORD(:contra))");
    
    $this->db->bind(':nombre', $nombre);
    $this->db->bind(':correo', $correo);
    $this->db->bind(':contra', $contra);

    return $this->db->execute();
  }

  // @method  UPDATE 
  // @desc    Updates nombre and correo from Asesor of provided (idAsesor)
  public function updateAsesor($idAsesor, $nombre, $correo) {
    $query = 'UPDATE Asesor 
    SET nombre = :nombre,
      correo = :correo
    WHERE idAsesor = :idAsesor';

    $this->db->query($query);

    $this->db->bind(':idAsesor', $idAsesor);
    $this->db->bind(':nombre', $nombre);
    $this->db->bind(':correo', $correo);

    return $this->db->execute();

  }

  // UPDATE Asesor SET `password` = PASSWORD('$newPassword') WHERE Asesor.idAsesor = $idUsuario
  // @method  UPDATE 
  // @desc    Changes the password from Asesor of provided (idAsesor)
  public function changeAsesorPassword($idAsesor, $newPassword) {
    $query = 'UPDATE Asesor SET `password` = PASSWORD(:newPassword) WHERE Asesor.idAsesor = :idAsesor';

    $this->db->query($query);

    $this->db->bind(':idAsesor', $idAsesor);
    $this->db->bind(':newPassword', $newPassword);

    return $this->db->execute();

  }

  // @method  DELETE
  // @desc    Delete Asesor (idAsesor), STORE PROCEDURE
  public function deleteAsesor($idAsesor) {
    // Set to NULL: Asesoria
    $query = 'UPDATE Asesoria SET idAsesor = NULL WHERE idAsesor = :idAsesor';
    $this->db->query($query);
    $this->db->bind(':idAsesor', $idAsesor);
    $res = $this->db->execute();
    if (!$res) return $res;

    // Set to NULL Turno
    $query = 'UPDATE Turno SET idAsesor = NULL WHERE idAsesor = :idAsesor';
    $this->db->query($query);
    $this->db->bind(':idAsesor', $idAsesor);
    $res = $this->db->execute();
    if (!$res) return $res;

    // Perform DELETE
    $query = 'DELETE FROM Asesor WHERE idAsesor = :idAsesor';
    $this->db->query($query);
    $this->db->bind(':idAsesor', $idAsesor);

    return $this->db->execute();

  }

  // @method  SELECT
  // @desc    Grupos que maneja el Asesor
  public function getGruposDeAsesor($idAsesor) {
    $query = 'SELECT Grupo.grupo, Grupo.idGrupo FROM Asesor 
    JOIN Turno ON Asesor.idAsesor = Turno.idAsesor
    JOIN Grupo ON Grupo.idTurno = Turno.idTurno
    WHERE Asesor.idAsesor = :idAsesor';

    $this->db->query($query);

    $this->db->bind(':idAsesor', $idAsesor);

    return $this->db->resultSet();
  }

  // @method  INSERT
  // @desc    Agregar nueva entrada de diario de campo
  public function insertarNuevaEntrada($idAsesor, $idGrupo, $anotacion) {
    $query = 'INSERT INTO DiarioCampo (idGrupo, idAsesor, Anotacion) 
      VALUES (:idGrupo, :idAsesor, :anotacion)';

    $this->db->query($query);

    $this->db->bind(':idAsesor', $idAsesor);
    $this->db->bind(':idGrupo', $idGrupo);
    $this->db->bind(':anotacion', $anotacion);

    return $this->db->execute();
  }

  // @method  SELECT
  // @desc    Obtiene todas las entradas del diario de campo de un Asesor
  public function getEntradas($idAsesor) {
    $query = 'SELECT Grupo.idGrupo, Grupo.grupo as Grupo, DiarioCampo.Fecha, DiarioCampo.Anotacion 
      FROM DiarioCampo 
      JOIN Asesor ON DiarioCampo.idAsesor = Asesor.idAsesor 
      JOIN Grupo on DiarioCampo.idGrupo = Grupo.idGrupo 
      WHERE Asesor.idAsesor = :idAsesor';

    $this->db->query($query);

    $this->db->bind(':idAsesor', $idAsesor);

    return $this->db->resultSet();
  }

  // @method  SELECT
  // @desc    Obtiene historial de asesorias de Asesor con opcion de filtrado de mes
  public function getAsesorias($idAsesor, $mes = null) {
    $query = 'SELECT
      Asesoria.idAsesoria AS idAsesoria 
      , Alumno.idAlumno AS idAlumno 
      , CONCAT(Alumno.nombre," ",Alumno.apellido) AS Alumno
      , DATE_FORMAT(Asesoria.fecha, "%d-%m-%Y") AS Fecha 
      , Motivo.motivo AS Motivo
      , Integrantes.descripcion AS Dinamica 
      , Asesoria.observaciones AS Observaciones
    FROM Asesoria 
    JOIN Alumno on Alumno.idAlumno = Asesoria.idAlumno 
    JOIN Asesor on Asesor.idAsesor = Asesoria.idAsesor 
    JOIN Motivo on Motivo.idMotivo = Asesoria.idMotivo 
    JOIN Integrantes on Integrantes.idIntegrantes = Asesoria.idIntegrantes
    WHERE Asesor.idAsesor = :idAsesor';

    if (!is_null($mes)) {
      $query .= ' AND MONTH(Asesoria.fecha) = :mes';
    }

    $query .= ' ORDER BY Asesoria.fecha DESC';

    $this->db->query($query);

    $this->db->bind(':idAsesor', $idAsesor);
    if (!is_null($mes)) {
      $this->db->bind(':mes', $mes);
    }

    return $this->db->resultSet();
  }

  // @method  SELECT
  // @desc    Obtiene todas los turnos (de que escuelas) que atiende un Asesor
  public function getTurnos($idAsesor = '') {
    $query = 'SELECT 
      Asesor.idAsesor as idAsesor,
      Turno.idTurno as idTurno,
      Asesor.nombre as nombreAsesor, 
      Turno.idTurno, CONCAT(Escuela.nombre, ", ", Turno.tipo) as turno
      FROM Turno 
      JOIN Asesor ON Turno.idAsesor = Asesor.idAsesor
      JOIN Escuela ON Turno.idEscuela = Escuela.idEscuela';

    if (!empty($idAsesor)) {
      $query .= ' WHERE Asesor.idAsesor = :idAsesor';
    }

    $this->db->query($query);

    if (!empty($idAsesor)) {
      $this->db->bind(':idAsesor', $idAsesor);
    }

    return $this->db->resultSet();
  }

}