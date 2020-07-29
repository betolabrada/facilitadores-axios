<?php

class Asesoria {

  private $db;

  public function __construct() {
    $this->db = new Database();
  }

  public function getAsesoriasCSV() {

    $asesorias = $this->db->query("SELECT CONCAT(Alumno.nombre,' ',Alumno.apellido) AS alumno
        , Grupo.grupo
        , Asesor.nombre AS asesor
        , Escuela.nombre AS escuela
        , Turno.descripcion AS turno
        , DATE_FORMAT(Asesoria.fecha, '%d-%m-%Y') AS fecha_aseso
        , Motivo.motivo AS motivo
        , Integrantes.descripcion AS dinamica
        , Asesoria.observaciones AS observaciones
        FROM Asesoria
        JOIN Alumno on Alumno.idAlumno = Asesoria.idAlumno
        JOIN Grupo on Alumno.idGrupo = Grupo.idGrupo
        JOIN Asesor on Asesor.idAsesor = Asesoria.idAsesor
        JOIN Motivo on Motivo.idMotivo = Asesoria.idMotivo
        JOIN Integrantes on Integrantes.idIntegrantes = Asesoria.idIntegrantes
        JOIN Turno on Turno.idAsesor = Asesor.idAsesor
        JOIN Escuela on Escuela.idEscuela = Turno.idEscuela
        JOIN Localidad on Localidad.idLocalidad = Escuela.idLocalidad
        ORDER BY Asesoria.fecha DESC");
      
    return $asesorias;
  }

  public function getAsesoriasTabla($filters = "") {
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
        WHERE 1 $filters
        ORDER BY Asesoria.fecha DESC";

    $this->db->query($sql);
    
    return $this->db->resultSet();
  }

  public function exportarCSV() {
    header('Content-Type: text/csv;charset=utf-8');
    header('Content-Disposition: attachment; filename="datos.csv"');
    $where = "";
    $output = fopen('php://output', 'wb');
    fputcsv($output, array("Asesoria No.", "ID Alumno", "Nombre", "idAsesor", "Asesor", "Fecha", "Motivo", "Dinamica", "Observaciones"));
    print_r($_POST);

    $asesor = $_POST['asesor'];
    $sede = $_POST['sede'];
    $escuela = $_POST['escuela'];
    $anio = $_POST['anio'];
    $mes = $_POST['mes'];
    $rangoDeFechasInicio = $_POST['rangoDeFechasInicio'];
    $rangoDeFechasFin = $_POST['rangoDeFechasFin'];

    if ($asesor) $where .= " AND Asesor.idAsesor = '$asesor'";
    if ($sede) $where .= " AND Localidad.idLocalidad = '$sede'";
    if ($escuela) $where .= " AND Escuela.idEscuela = " . $escuela . " ";
    if ($anio) $where .= " AND YEAR(Asesoria.fecha) = '" . $anio . "' ";
    if ($mes) $where .= " AND MONTH(Asesoria.fecha) = " . $mes;
    if (isset($_POST['filtroFecha']) && $rangoDeFechasInicio && $rangoDeFechasFin) {
        $where .= " AND Asesoria.fecha BETWEEN '$rangoDeFechasInicio' AND '$rangoDeFechasFin'";
    }

    $asesoriasFiltrado = $asesoria->getAsesoriasTabla($where);

    while ($row = $asesoriasFiltrado->fetch_assoc()) {
      extract($row);

      $toCSV = array(
      'idAsesoria' => utf8_decode($idAsesoria),
      'id' => utf8_decode($id),
      'alumno' => utf8_decode($alumno),
      'idAsesor' => utf8_decode($idAsesor),
      'asesor' => utf8_decode($asesor),
      'fecha' => $fecha,
      'motivo' => utf8_decode($motivo),
      'dinamica' => utf8_decode($dinamica),
      'observaciones' => utf8_decode($observaciones),
      );
      fputcsv($output, $toCSV);
    }

    fclose($output);
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
  // @tables    Tipo
  // @fields    *.tipoasesoria
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
  // @tables    Tipo
  // @fields    *
  public function getTipo($idTipoAsesoria) {

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
  public function insertAsesoria($idAlumno, $idMotivo, $idAsesor, $idIntegrantes, $fecha, $obs) {

    $query = 'INSERT INTO Asesoria (idAlumno, idMotivo, idAsesor, idIntegrantes, fecha, observaciones)
      VALUES (:idAlumno, :idMotivo, :idAsesor, :idIntegrantes, :fecha, :obs)';
    
    $this->db->query($query);

    $this->db->bind(':idAlumno', $idAlumno);
    $this->db->bind(':idMotivo', $idMotivo);
    $this->db->bind(':idAsesor', $idAsesor);
    $this->db->bind(':idIntegrantes', $idIntegrantes);
    $this->db->bind(':fecha', $fecha);
    $this->db->bind(':obs', $obs);

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


}