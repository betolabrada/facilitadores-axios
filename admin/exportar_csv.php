<?php
session_start();

// function exportar($pAlumnos, $filename) {
//   header('Content-Type: text/csv;charset=utf-8');
//   header('Content-Disposition: attachment; filename="'. $filename. '"');
//   $output = fopen('php://output', 'wb');
//   fputcsv($output, array("noLista", "nombre", "apellido", "idGrupo"));
//   while($row = $pAlumnos->fetch_assoc()) {
//     extract($row);
//     fputcsv($output, array( 
//       'noLista' => utf8_decode($noLista),
//       'nombre' => utf8_decode($nombre),
//       'apellido' => utf8_decode($apellido),
//     ));
//   }
//   fclose($output);
// }
// if (isset($_POST['exportar_todo'])) {
//   header('Content-Type: text/csv;charset=utf-8');
//   header('Content-Disposition: attachment; filename="asesorias_completo.csv"');
//   $output = fopen('php://output', 'wb');
//   fputcsv($output, array("alumno", "grupo", "asesor", "escuela", "turno", "fecha_aseso",
//    "motivo", "dinamica", "observaciones"));

//   $asesorias = $asesoria->getAsesoriasCSV();

//   while ($row = $asesorias->fetch_assoc()) {
//     extract($row);
//     fputcsv($output, array( 
//       'alumno' => utf8_decode($alumno),
//       'grupo' => utf8_decode($grupo),
//       'asesor' => utf8_decode($asesor),
//       'escuela' => utf8_decode($escuela),
//       'turno' => utf8_decode($turno),
//       'fecha_aseso' => utf8_decode($fecha_aseso),
//       'motivo' => utf8_decode($motivo),
//       'dinamica' => utf8_decode($dinamica),
//       'observaciones' => utf8_decode($observaciones),
//     ));
//   }
//   fclose($output);
// }

// if (isset($_POST['exportar_grupo'])) {
//   $grupoId = $_GET['id'];
//   $pAlumnos = $db->getAllAlumnos($grupoId);
//   exportar($pAlumnos, "alumnos_data.csv");
// }

// if (isset($_POST['exportar'])) {
//   // $where = isset($_POST['filters']) ? $_POST['filters'] : "";
//   header('Content-Type: text/csv;charset=utf-8');
//   header('Content-Disposition: attachment; filename="datos.csv"');
//   $output = fopen('php://output', 'wb');
//   fputcsv($output, array("Asesoria No.", "ID Alumno", "Nombre", "idAsesor", "Asesor", "Fecha", "Motivo", "Dinamica", "Observaciones"));
  
//   $asesorias_csv = $asesoria->CSV();

//   foreach ($asesorias_csv as $row) {
//     extract($row);

//     $toCSV = array(
//       'idAsesoria' => utf8_decode($idAsesoria),
//       'id' => utf8_decode($id),
//       'alumno' => utf8_decode($alumno),
//       'idAsesor' => utf8_decode($idAsesor),
//       'asesor' => utf8_decode($asesor),
//       'fecha' => $fecha,
//       'motivo' => utf8_decode($motivo),
//       'dinamica' => utf8_decode($dinamica),
//       'observaciones' => utf8_decode($observaciones),
//     );
//     fputcsv($output, $toCSV);
//   }
  
//}

// Lo único que se necesita para exportar es tener seteada la tabla en $_SESSION['toExport'] y llamar el metodo
// exportar en un form de tipo GET con formaction a este archivo.
// Ej: <button type="submit" name="exportar" formaction="exportar_csv.php" value="Exportar">Exportar</button>
// Tabla debe ser UN solo array SIMPLE que contenga associative arrays (los registros) como sus elementos.
extract($_SESSION);

if (isset($_GET['exportar']) && isset($toExport)) {
  // Headers PHP para convertir a CSV
  header('Content-Type: text/csv;charset=utf-8');
  header('Content-Disposition: attachment; filename="output.csv"');
  // Creamos archivo
  $output = fopen('php://output', 'wb');
  $first = true;
  // Insertamos cada row
  foreach ($toExport as $row) {
    // Si es la primera fila a insertar, agregar header primero
    if ($first) {
      $decoded_header = array_map(function($el) { return utf8_decode($el); }, array_keys($row));
      fputcsv($output, $decoded_header);
      $first = false;
    }
    // Decode record para que no haya caracteres extraños
    $decoded = array_map(function($el) { return utf8_decode($el); }, array_values($row));
    fputcsv($output, $decoded);
  }
  unset($toExport);
  fclose($output);
}

?>