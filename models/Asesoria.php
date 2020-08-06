<?php

class Asesoria {

  private $db;

  public function __construct() {
    $this->db = new Database();
  }

  public function getAsesorias($filters = null) {
    $sql =
        "SELECT
            Asesoria.idAsesoria AS idAsesoria
            , Alumno.idAlumno AS idAlumno
            , CONCAT(Alumno.nombre,' ',Alumno.apellido) AS alumno
            , Asesor.idAsesor AS idAsesor
            , Asesor.nombre AS asesor
            , DATE_FORMAT(Asesoria.fecha, '%d-%m-%Y') AS fecha
            , Motivo.motivo AS motivo
            , Integrantes.descripcion AS dinamica
            , Asesoria.observaciones AS observaciones
        FROM Asesoria
        JOIN Alumno on Alumno.idAlumno = Asesoria.idAlumno
        JOIN Asesor on Asesor.idAsesor = Asesoria.idAsesor
        JOIN Motivo on Motivo.idMotivo = Asesoria.idMotivo
        JOIN Integrantes on Integrantes.idIntegrantes = Asesoria.idIntegrantes
        JOIN Turno on Turno.idAsesor = Asesor.idAsesor
        JOIN Escuela on Escuela.idEscuela = Turno.idEscuela
        JOIN Localidad on Localidad.idLocalidad = Escuela.idLocalidad
        WHERE 1";
    
    if (!is_null($filters)) {
      $sql .= '';
    }

    $sql .= ' ORDER BY Asesoria.fecha DESC';

    $this->db->query($sql);
    
    return $this->db->resultSet();
  }

  public function ultimasAsesorias() {
    $sql = "SELECT 
      Asesoria.idAsesoria AS idAsesoria 
      , Alumno.idAlumno AS idAlumno 
      , CONCAT(Alumno.nombre,' ',Alumno.apellido) AS alumno
      , Asesor.idAsesor AS idAsesor
      , Asesor.nombre AS asesor
      , DATE_FORMAT(Asesoria.fecha, '%d-%m-%Y') AS fecha 
      , Motivo.motivo AS motivo
      , Integrantes.descripcion AS dinamica 
      , Asesoria.observaciones AS observaciones
    FROM Asesoria 
    JOIN Alumno on Alumno.idAlumno = Asesoria.idAlumno 
    JOIN Asesor on Asesor.idAsesor = Asesoria.idAsesor 
    JOIN Motivo on Motivo.idMotivo = Asesoria.idMotivo 
    JOIN Integrantes on Integrantes.idIntegrantes = Asesoria.idIntegrantes
    ORDER BY Asesoria.idAsesoria DESC 
    LIMIT 5";

    $this->db->query($sql);

    return $this->db->resultSet();
      
  }

  public function ultimasAsesoriasDeAsesor($idAsesor) {
    $sql = "SELECT 
      Asesoria.idAsesoria AS idAsesoria 
      , Alumno.idAlumno AS id 
      , CONCAT(Alumno.nombre,' ',Alumno.apellido) AS Alumno
      , DATE_FORMAT(Asesoria.fecha, '%d-%m-%Y') AS Fecha 
      , Motivo.motivo AS Motivo
      , Integrantes.descripcion AS Dinamica 
      , Asesoria.observaciones AS Observaciones
    FROM Asesoria 
    JOIN Alumno on Alumno.idAlumno = Asesoria.idAlumno 
    JOIN Asesor on Asesor.idAsesor = Asesoria.idAsesor 
    JOIN Motivo on Motivo.idMotivo = Asesoria.idMotivo 
    JOIN Integrantes on Integrantes.idIntegrantes = Asesoria.idIntegrantes
    WHERE Asesor.idAsesor = :idAsesor
    ORDER BY Asesoria.idAsesoria DESC 
    LIMIT 5";

    $this->db->query($sql);

    $this->db->bind(':idAsesor', $idAsesor);

    return $this->db->resultSet();
  }
  
  public function stats($filters="") {
    $sql =
            "SELECT COUNT(Asesoria.idAsesoria) AS totalAsesorias,
                    COUNT(DISTINCT Asesoria.idAlumno) AS totalAlumnos,
                    COUNT(DISTINCT CASE WHEN Asesoria.idIntegrantes = 1 THEN Asesoria.idAsesoria END) AS totalConAlumno,
                    COUNT(DISTINCT CASE WHEN Asesoria.idIntegrantes = 2 THEN Asesoria.idAsesoria END) AS totalConPadres
            FROM Asesoria
            JOIN Alumno on Alumno.idAlumno = Asesoria.idAlumno
            JOIN Asesor on Asesor.idAsesor = Asesoria.idAsesor
            JOIN Motivo on Motivo.idMotivo = Asesoria.idMotivo
            JOIN Integrantes on Integrantes.idIntegrantes = Asesoria.idIntegrantes
            JOIN Turno on Turno.idAsesor = Asesor.idAsesor
            JOIN Escuela on Escuela.idEscuela = Turno.idEscuela
            JOIN Localidad on Localidad.idLocalidad = Escuela.idLocalidad
            $filters";

    $this->db->query($sql);

    return $this->db->single();
  }

  public function getAsesoriasDeAsesor($idAsesor) {
    $this->db->query("SELECT 
      Asesoria.idAsesoria AS idAsesoria 
      , Alumno.idAlumno AS id 
      , CONCAT(Alumno.nombre,' ',Alumno.apellido) AS Alumno
      , DATE_FORMAT(Asesoria.fecha, '%d-%m-%Y') AS Fecha 
      , Motivo.motivo AS Motivo
      , Integrantes.descripcion AS Dinamica 
      , Asesoria.observaciones AS Observaciones
    FROM Asesoria 
    JOIN Alumno on Alumno.idAlumno = Asesoria.idAlumno 
    JOIN Asesor on Asesor.idAsesor = Asesoria.idAsesor 
    JOIN Motivo on Motivo.idMotivo = Asesoria.idMotivo 
    JOIN Integrantes on Integrantes.idIntegrantes = Asesoria.idIntegrantes
    WHERE Asesor.idAsesor = :idAsesor
    ORDER BY Asesoria.idAsesoria DESC");

    $this->db->bind(':idAsesor', $idAsesor);

    return $this->db->resultSet();
  }

  // @method    SELECT
  // @desc      GET Asesorias of alumno 
  // @tables    Asesoria, Alumno, Motivo, Dinámica
  // @fields    fecha, motivo, dinamica, observaciones
  public function getAsesoriasDeAlumno($idAlumno) {
    $query = "SELECT 
          Asesoria.idAsesoria AS idAsesoria 
          , Alumno.idAlumno AS id 
          , CONCAT(Alumno.nombre,' ',Alumno.apellido) AS Alumno
          , DATE_FORMAT(Asesoria.fecha, '%d-%m-%Y') AS Fecha 
          , Motivo.motivo AS Motivo
          , Integrantes.descripcion AS Dinamica 
          , Asesoria.observaciones AS Observaciones
      FROM Asesoria 
      JOIN Alumno on Alumno.idAlumno = Asesoria.idAlumno 
      JOIN Asesor on Asesor.idAsesor = Asesoria.idAsesor 
      JOIN Motivo on Motivo.idMotivo = Asesoria.idMotivo 
      JOIN Integrantes on Integrantes.idIntegrantes = Asesoria.idIntegrantes
      WHERE Alumno.idAlumno = :idAlumno
      ORDER BY Asesoria.fecha DESC";
    
    $this->db->query($query);

    $this->db->bind(':idAlumno', $idAlumno);

    return $this->db->resultSet();

  }

  public function getAsesoriaById($idAsesoria) {
    $this->db->query("SELECT * FROM Asesoria WHERE idAsesoria = :idAsesoria");
    
    $this->db->bind(':idAsesoria', $idAsesoria);

    return $this->db->resultSet();
  }
  
  // @method    SELECT
  // @desc      Get tipos de asesoria
  public function getTipos() {

    $query = "SELECT idTipoAsesoria id, tipoAsesoria tipo FROM TipoAsesoria";
    
    $this->db->query($query);

    return $this->db->resultSet();

  }

  // @method    SELECT
  // @desc      Get motivos de asesoria of a tipo
  // @tables    Motivo
  // @fields    *.motivoAsesoria
  public function getMotivos($idTipoAsesoria) {

    $query = "SELECT 
    idMotivo AS id, 
    motivo AS motivo
    FROM Motivo
    WHERE idTipoAsesoria = :idTipoAsesoria";
    
    $this->db->query($query);

    $this->db->bind(':idTipoAsesoria', $idTipoAsesoria);

    return $this->db->resultSet();

  }

  // @method    SELECT
  // @desc      Get tipo de asesoria by its id
  public function getTipoById($idTipoAsesoria) {

    $query = "SELECT *
    FROM TipoAsesoria
    WHERE idTipoAsesoria = :idTipoAsesoria";
    
    $this->db->query($query);

    $this->db->bind(':idTipoAsesoria', $idTipoAsesoria);

    $row = $this->db->single();

    return $row['tipoAsesoria'];

  }

  // @method    SELECT
  // @desc      Get motivo de asesoria by its id
  // @tables    Motivo
  // @fields    *
  public function getMotivo($idMotivo) {

    $query = "SELECT *
    FROM Motivo
    WHERE idMotivo = :idMotivo";
    
    $this->db->query($query);

    $this->db->bind(':idMotivo', $idMotivo);

    $row = $this->db->single();

    return $row['motivo'];

  }

  // @method    INSERT
  // @desc      Insert new asesoria (idAlumno, idMotivo, idAsesor, idIntegrantes, fecha, observaciones)
  // @tables    Asesoria
  // @fields    *
  public function insertAsesoria($params) {
    extract($params);
    $query = 'INSERT INTO Asesoria (idAlumno, idMotivo, idAsesor, idIntegrantes, fecha, observaciones)
      VALUES (:idAlumno, :idMotivo, :idAsesor, :idIntegrantes, :fecha, :observaciones)';
    
    $this->db->query($query);

    $this->db->bind(':idAlumno', $idAlumno);
    $this->db->bind(':idMotivo', $idMotivo);
    $this->db->bind(':idAsesor', $idAsesor);
    $this->db->bind(':idIntegrantes', $idIntegrantes);
    $this->db->bind(':fecha', $fecha);
    $this->db->bind(':observaciones', $observaciones);

    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }

  // 
  // @method    SELECT
  // @desc      Tabla para exportar CSV
  // @fields    "Asesoria No.", "ID Alumno", "Nombre", "idAsesor", "Asesor", "Fecha", "Motivo", 
  //              "Dinamica", "Observaciones"
  public function CSV() {
    $query = "SELECT 
        Asesoria.idAsesoria AS idAsesoria 
        , Alumno.idAlumno AS id 
        , CONCAT(Alumno.nombre,' ',Alumno.apellido) AS alumno
        , Asesor.idAsesor AS idAsesor
        , Asesor.nombre AS asesor
        , DATE_FORMAT(Asesoria.fecha, '%d-%m-%Y') AS fecha 
        , Motivo.motivo AS motivo
        , Integrantes.descripcion AS dinamica 
        , Asesoria.observaciones AS observaciones
    FROM Asesoria 
    JOIN Alumno on Alumno.idAlumno = Asesoria.idAlumno 
    JOIN Asesor on Asesor.idAsesor = Asesoria.idAsesor 
    JOIN Motivo on Motivo.idMotivo = Asesoria.idMotivo 
    JOIN Integrantes on Integrantes.idIntegrantes = Asesoria.idIntegrantes
    ORDER BY Asesoria.idAsesoria DESC";

    $this->db->query($query);

    return $this->db->resultSet();
  }
  
  public function deleteAsesoria($idAsesoria){
       $query = 'DELETE FROM Asesoria WHERE idAsesoria = :idAsesoria';

        $this->db->query($query);

        $this->db->bind(':idAsesoria', $idAsesoria);

        return $this->db->execute();
  }
  
  public function deleteAsesoriaFecha($idAlumno,$fecha){
      $query = 'DELETE FROM Asesoria
	WHERE idAlumno = :idAlumno AND fecha = :fecha';
        
      $this->db->query($query);

      $this->db->bind(':idAlumno', $idAlumno);
      $this->db->bind(':fecha', $fecha);

      if ($this->db->execute()) {
          return true;
      }
      return false;
  }

  public function updateAsesoria($variable,$variableChange,$idAlumno,$fecha){
      $query = 'UPDATE Asesoria
	SET :variable = :varibleChange
        WHERE idAlumno = :idAlumno AND fecha = :fecha';
        
      $this->db->query($query);
        
      $this->db->bind(':variable', $variable);
      $this->db->bind(':varibleChange', $variableChange);
      $this->db->bind(':idAlumno', $idAlumno);
      $this->db->bind(':fecha', $fecha);
        
      if ($this->db->execute()) {
         return true;
      }
      return false;
  }

}