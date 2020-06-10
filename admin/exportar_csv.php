<?php
  if (isset($_POST['exportar'])) {
    $where = $_POST['where'];
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
    $where
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

    fclose($output);
  }
