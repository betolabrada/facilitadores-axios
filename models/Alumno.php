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
      a.idAlumno AS id, 
      CONCAT(a.nombre,' ', a.apellido) AS Alumno, 
      e.nombre AS Escuela, 
      ga.numero AS Grado, 
      gu.grupo AS Grupo
              FROM Alumno as a JOIN Grupo as gu
              ON a.idGrupo = gu.idGrupo
              JOIN Grado as ga
              ON gu.idGrado = ga.idGrado
              JOIN Turno as t
              ON ga.idTurno = t.idTurno
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
        a.idAlumno AS id, 
        CONCAT(a.nombre,' ', a.apellido) AS Alumno,
        a.nombre AS Nombres, 
        a.apellido AS Apellidos, 
        a.noLista AS NoLista,
        e.idEscuela AS Escuela,
        e.nombre AS nombreEscuela, 
        ga.numero AS Grado, 
        gu.idGrupo AS idGrupo,
        gu.grupo AS Grupo,
        ase.idAsesor AS idAsesor,
        ase.nombre AS NAsesor, 
      t.descripcion AS Turno
      FROM Alumno as a 
      JOIN Grupo as gu ON a.idGrupo = gu.idGrupo
      JOIN Grado as ga ON gu.idGrado = ga.idGrado
      JOIN Turno as t ON ga.idTurno = t.idTurno
      JOIN Escuela as e ON t.idEscuela = e.idEscuela
      JOIN Localidad as l ON l.idLocalidad = e.idLocalidad
      LEFT JOIN Asesor as ase ON t.idAsesor = ase.idAsesor
      WHERE a.idAlumno = :idAlumno";

    $this->db->query($query);

    $this->db->bind(':idAlumno', $idAlumno);

    return $this->db->single();

  }

  // @method  UPDATE
  // @desc    update ALUMNO
  // @fields  noLista, 
  //          
  public function updateAlumno($idAlumno) {
    $query = "SELECT 
        a.idAlumno AS id, 
        CONCAT(a.nombre,' ', a.apellido) AS Alumno,
        a.nombre AS Nombres, 
        a.apellido AS Apellidos, 
        a.noLista AS NoLista,
        e.idEscuela AS Escuela, 
        ga.numero AS Grado, 
        gu.idGrupo AS idGrupo,
        gu.grupo AS Grupo,
        ase.idAsesor AS idAsesor,
        ase.nombre AS NAsesor, 
      t.descripcion AS Turno
      FROM Alumno as a 
      JOIN Grupo as gu ON a.idGrupo = gu.idGrupo
      JOIN Grado as ga ON gu.idGrado = ga.idGrado
      JOIN Turno as t ON ga.idTurno = t.idTurno
      JOIN Escuela as e ON t.idEscuela = e.idEscuela
      JOIN Localidad as l ON l.idLocalidad = e.idLocalidad
      LEFT JOIN Asesor as ase ON t.idAsesor = ase.idAsesor
      WHERE a.idAlumno = :idAlumno";

    $this->db->query($query);

    $this->db->bind(':idAlumno', $idAlumno);

    return $this->db->single();

  }


  // @method  SELECT
  // @desc    GET ALUMNO DE ASESOR
  // @fields  id, alumno(nombre completo), nombres, apellidos, noLista, escuela(id), grado, grupo, 
  //          idAsesor, Nasesor, turno
  public function getAlumnosDeAsesor($idAsesor) {

    $query = "SELECT a.idAlumno AS id, CONCAT(a.nombre,' ', a.apellido) AS Alumno, 
    e.nombre AS Escuela, ga.numero AS Grado, gu.grupo AS Grupo
    FROM Alumno as a JOIN Grupo as gu
    ON a.idGrupo = gu.idGrupo
    JOIN Grado as ga
    ON gu.idGrado = ga.idGrado
    JOIN Turno as t
    ON ga.idTurno = t.idTurno
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

}