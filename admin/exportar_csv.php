<?php
include '../config/init.php';

$asesoria = new Asesoria;


function exportar($pAlumnos, $filename) {
  header('Content-Type: text/csv;charset=utf-8');
  header('Content-Disposition: attachment; filename="'. $filename. '"');
  $output = fopen('php://output', 'wb');
  fputcsv($output, array("noLista", "nombre", "apellido", "idGrupo"));
  while($row = $pAlumnos->fetch_assoc()) {
    extract($row);
    fputcsv($output, array( 
      'noLista' => utf8_decode($noLista),
      'nombre' => utf8_decode($nombre),
      'apellido' => utf8_decode($apellido),
    ));
  }
  fclose($output);
}
if (isset($_POST['exportar_todo'])) {
  header('Content-Type: text/csv;charset=utf-8');
  header('Content-Disposition: attachment; filename="asesorias_completo.csv"');
  $output = fopen('php://output', 'wb');
  fputcsv($output, array("alumno", "grupo", "asesor", "escuela", "turno", "fecha_aseso",
   "motivo", "dinamica", "observaciones"));

  $asesorias = $asesoria->getAsesoriasCSV();

  while ($row = $asesorias->fetch_assoc()) {
    extract($row);
    fputcsv($output, array( 
      'alumno' => utf8_decode($alumno),
      'grupo' => utf8_decode($grupo),
      'asesor' => utf8_decode($asesor),
      'escuela' => utf8_decode($escuela),
      'turno' => utf8_decode($turno),
      'fecha_aseso' => utf8_decode($fecha_aseso),
      'motivo' => utf8_decode($motivo),
      'dinamica' => utf8_decode($dinamica),
      'observaciones' => utf8_decode($observaciones),
    ));
  }
  fclose($output);
}

if (isset($_POST['exportar_grupo'])) {
  $grupoId = $_GET['id'];
  $pAlumnos = $db->getAllAlumnos($grupoId);
  exportar($pAlumnos, "alumnos_data.csv");
}

if (isset($_POST['exportar'])) {
  $where = isset($_POST['filters']) ? $_POST['filters'] : "";
  include "../config/Conn.php";
  header('Content-Type: text/csv;charset=utf-8');
  header('Content-Disposition: attachment; filename="datos.csv"');
  $output = fopen('php://output', 'wb');
  fputcsv($output, array("Asesoria No.", "ID Alumno", "Nombre", "idAsesor", "Asesor", "Fecha", "Motivo", "Dinamica", "Observaciones"));
  $query = 
  "SELECT 
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
  WHERE 1 $where
  ORDER BY Asesoria.idAsesoria DESC";

  
  $result = $conn->query($query);

  if ($result) {
    while ($row = $result->fetch_assoc()) {
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
  }
}