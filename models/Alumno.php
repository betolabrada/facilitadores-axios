<?php 
class Alumno {
  private $db;

  public function __construct() {
    $this->db = new Database();
  }

  // @method  SELECT
  // @desc    GET ALUMNOS with filters
  // @fields  id, alumno(nombre completo), escuela(nombre), grado, grupo, 
  public function getAlumnos() {
    $query = "SELECT 
      a.idAlumno AS idAlumno, 
      CONCAT(a.nombre,' ', a.apellido) AS Alumno, 
      e.nombre AS Escuela, 
      gu.grupo AS Grupo
              FROM Alumno as a JOIN Grupo as gu
              ON a.idGrupo = gu.idGrupo
              JOIN Turno as t
              ON gu.idTurno = t.idTurno
              JOIN Escuela as e
              ON t.idEscuela = e.idEscuela
              JOIN Localidad as l
              on l.idLocalidad = e.idLocalidad
              LEFT JOIN Asesor as ase
              ON t.idAsesor = ase.idAsesor
              ORDER BY Alumno ASC";
  

    $this->db->query($query);

    return $this->db->resultSet();


  }

  // @method  SELECT
  // @desc    GET ALUMNO BY ITS ID
  // @fields  id, alumno(nombre completo), nombres, apellidos, noLista, escuela(id, nombre), grado, grupo, 
  //          idAsesor, Nasesor, turno
  public function getAlumnoById($idAlumno) {
    $query = "SELECT 
        a.idAlumno AS idAlumno, 
        CONCAT(a.nombre,' ', a.apellido) AS Alumno,
        a.nombre AS Nombres, 
        a.apellido AS Apellidos, 
        a.noLista AS NoLista,
        e.idEscuela AS Escuela,
        e.nombre AS nombreEscuela, 
        gu.idGrupo AS idGrupo,
        gu.grupo AS Grupo,
        ase.idAsesor AS idAsesor,
        ase.nombre AS NAsesor, 
      t.descripcion AS Turno
      FROM Alumno as a 
      JOIN Grupo as gu ON a.idGrupo = gu.idGrupo
      JOIN Turno as t ON gu.idTurno = t.idTurno
      JOIN Escuela as e ON t.idEscuela = e.idEscuela
      JOIN Localidad as l ON l.idLocalidad = e.idLocalidad
      LEFT JOIN Asesor as ase ON t.idAsesor = ase.idAsesor
      WHERE a.idAlumno = :idAlumno";

    $this->db->query($query);

    $this->db->bind(':idAlumno', $idAlumno);

    return $this->db->single();

  }

  // Insertar alumno
  public function insertarAlumno($noLista, $nombre, $apellido, $idGrupo, $idAlumno = NULL) {
    $sql = "INSERT INTO Alumno (idAlumno, noLista, nombre, apellido, idGrupo)
      VALUES (:idAlumno, :noLista, :nombre, :apellido, :idGrupo)";

    $this->db->query($sql);
    $this->db->bind(':idAlumno', $idAlumno, PDO::PARAM_INT);
    $this->db->bind(':noLista', $noLista);
    $this->db->bind(':nombre', $nombre);
    $this->db->bind(':apellido', $apellido);
    $this->db->bind(':idGrupo', $idGrupo);

    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }

  // @method  UPDATE
  // @desc    update ALUMNO
  // @fields  noLista, 
  //          
  public function updateAlumno($idAlumno, $noLista, $nombres, $apellidos, $idGrupo) {
    $query = 'UPDATE Alumno 
    SET noLista = :noLista, 
      nombre = :nombres, 
      apellido = :apellidos, 
      idGrupo= :idGrupo 
    WHERE idAlumno = :idAlumno';

    $this->db->query($query);

    $this->db->bind(':idAlumno', $idAlumno);
    $this->db->bind(':noLista', $noLista);
    $this->db->bind(':nombres', $nombres);
    $this->db->bind(':apellidos', $apellidos);
    $this->db->bind(':idGrupo', $idGrupo);

    return $this->db->execute();
  }


  // @method  SELECT
  // @desc    GET ALUMNO DE ASESOR
  // @fields  id, alumno(nombre completo), nombres, apellidos, noLista, escuela(id), grado, grupo, 
  //          idAsesor, Nasesor, turno
  public function getAlumnosDeAsesor($idAsesor) {

    $query = "SELECT a.idAlumno AS id, CONCAT(a.nombre,' ', a.apellido) AS Alumno, 
    e.nombre AS Escuela, gu.grupo AS Grupo
    FROM Alumno as a JOIN Grupo as gu
    ON a.idGrupo = gu.idGrupo
    JOIN Turno as t
    ON gu.idTurno = t.idTurno
    JOIN Escuela as e
    ON t.idEscuela = e.idEscuela
    LEFT JOIN Asesor as ase
    ON t.idAsesor = ase.idAsesor
    WHERE ase.idAsesor = :idAsesor
    ORDER BY Alumno ASC";

    $this->db->query($query);

    $this->db->bind(':idAsesor', $idAsesor);

    return $this->db->resultSet();

  }

  // @method    DELETE
  // @desc      Borra alumno pasando su id
  public function deleteAlumno($idAlumno, $tambienAse) {
    // If borrar tambien asesorias
    if ($tambienAse) {
      $sql = 'DELETE FROM Asesoria WHERE idAlumno = :idAlumno';
      $this->db->query($sql);
      $this->db->bind(':idAlumno', $idAlumno);
      $res = $this->db->execute();
      if (!$res) return false;
    } else {
      // Setear a NULL
      $sql = 'UPDATE Asesoria SET idAlumno = NULL WHERE idAlumno = :idAlumno';
      $this->db->query($sql);
      $this->db->bind(':idAlumno', $idAlumno);
      $res = $this->db->execute();
      if (!$res) return false;
    }

    $sql = 'DELETE FROM Alumno WHERE idAlumno = :idAlumno';
  
    $this->db->query($sql);

    $this->db->bind(':idAlumno', $idAlumno);

    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }

  // Borra todos los alumnos de un grupo (limpia de lista)
  public function deleteLista($idGrupo) {
    $sql = 'DELETE FROM Alumno WHERE idGrupo = :idGrupo';

    $this->db->query($sql);

    $this->db->bind(':idGrupo', $idGrupo);

    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }

  // Asesorias de Alumno
  public function getAsesoriasDeAlumno($idAlumno) {
    $sql = 'SELECT 
        Asesoria.idAsesoria AS idAsesoria 
        , Alumno.idAlumno AS idAlumno 
        , CONCAT(Alumno.nombre," ",Alumno.apellido) AS Alumno
        , Asesor.idAsesor AS idAsesor
        , Asesor.nombre AS Asesor
        , DATE_FORMAT(Asesoria.fecha, "%d-%m-%Y") AS Fecha 
        , Motivo.motivo AS Motivo
        , Integrantes.descripcion AS Dinamica 
        , Asesoria.observaciones AS Observaciones
    FROM Asesoria 
    JOIN Alumno on Alumno.idAlumno = Asesoria.idAlumno 
    JOIN Asesor on Asesor.idAsesor = Asesoria.idAsesor 
    JOIN Motivo on Motivo.idMotivo = Asesoria.idMotivo 
    JOIN Integrantes on Integrantes.idIntegrantes = Asesoria.idIntegrantes
    WHERE Alumno.idAlumno = :idAlumno
    ORDER BY Asesoria.idAsesoria DESC';

    $this->db->query($sql);

    $this->db->bind(':idAlumno', $idAlumno);

    return $this->db->resultSet();

  }

}