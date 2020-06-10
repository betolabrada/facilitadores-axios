<?php include 'asesor_navbar.php';
session_start();

$where = "";
$_SESSION['idAsesor'] = $idAsesor = (int) $_GET['idAsesor'];
$_SESSION['idAlumno'] = $idAlumno = (int) $_GET['idAlumno'];
$_SESSION['idIntegrantes'] = $idIntegrantes = (int)$_GET['idIntegrantes'];
$_SESSION['idTipoAsesoria'] = $idTipoAsesoria = (int) $_GET['idTipoAsesoria'];
$_SESSION['idMotivoAsesoria'] = $idMotivoAsesoria = (int) $_GET['idMotivoAsesoria'];

include 'config/Conn.php';
$queryId = "SELECT correo FROM Asesor WHERE idAsesor = '$idAsesor'";
$resultadoId = $conn->query($queryId);
$resultadoId->data_seek(0);
$filaId = $resultadoId->fetch_assoc();
$mail = $filaId['correo'];
$conn->close();
?>

<?php
if (isset($_POST['aceptar'])) {
  $fecha = date('Y-m-d', strtotime($_POST['fecha']));
  $observaciones = $_POST['observaciones'];
  if($observaciones !== "") {
    $_SESSION['fecha'] = $fecha;
    $_SESSION['obs'] = $observaciones;
    echo "<script type='text/javascript'> document.location = 'concentrado_asesoria.php'; </script>";
  }
  $message = "Por favor escribe tus notas de la asesoría en la sección de observaciones";
  echo "<script type='text/javascript'>alert('$message');</script>";
}
?>


<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <?php
      include 'config/Conn.php';
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
            WHERE ase.idAsesor = $idAsesor AND a.idAlumno = $idAlumno";
      $resultado = $conn->query($query);

      $resultado->data_seek(0);
      $fila = $resultado->fetch_assoc()
      ?>
      <h4 class="display-4 text-center">Nueva asesoría con:</h4>
      <br>
      <h4 class="text-center"><?php echo $fila['Alumno']; ?></h4>
      <br>
      <form method="post" action="" id="insertForm">

      <?php
      $conn->close();
      ?>
      <div class="text-center">
        <div class="col-sm-2"></div>
          <label for="input-fecha">Fecha de la asesoría</label>
          <br>
          <input name="fecha" type="date" value="<?php echo date("Y-m-d")?>">
          <br>
          <br>
          <label for="input-observaciones">Observaciones</label>
          <br>
          <textarea name="observaciones" rows="10" cols="100" placeholder="Escribe aquí"></textarea>
          <br>
        <div class="col-sm-2"></div>
      </div>

      <div class="row my-4 justify-content-center">
        <div class="col-sm-3">
          <button type="submit" class="btn btn-success btn-lg btn-primary btn-block text-uppercase" name="aceptar" form="insertForm">Aceptar</button>
        </div>
        <div class="col-sm-3">
          <button class="btn btn-danger btn-lg btn-primary btn-block text-uppercase" onclick="window.location.href='asesor_dashboard.php?inputMail=<?php echo $mail; ?>'">Cancelar</button>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>

</body>

</html>