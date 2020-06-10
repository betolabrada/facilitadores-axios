<?php include 'asesor_navbar.php';
session_start();

$where = "";
$idAsesor = (int)$_SESSION['idAsesor'];
$idAlumno = (int)$_SESSION['idAlumno'];
$idIntegrantes = (int)$_SESSION['idIntegrantes'];
$idTipoAsesoria = (int)$_SESSION['idTipoAsesoria'];
$idMotivoAsesoria = (int)$_SESSION['idMotivoAsesoria'];
$fecha = $_SESSION['fecha'];
$observaciones = $_SESSION['obs'];

include 'config/Conn.php';
$queryId = "SELECT correo FROM Asesor WHERE idAsesor = '$idAsesor'";
$resultadoId = $conn->query($queryId);
$resultadoId->data_seek(0);
$filaId = $resultadoId->fetch_assoc();
$mail = $filaId['correo'];
$conn->close();
?>

<?php
if (isset($_POST['subir'])) {
  include 'config/Conn.php';
  $query = "INSERT INTO Asesoria (idAsesoria, idAlumno, idMotivo, idAsesor, idIntegrantes, fecha, observaciones)
            VALUES (NULL, $idAlumno, $idMotivoAsesoria, $idAsesor, $idIntegrantes, '$fecha', '$observaciones')";
  if ($conn->query($query) === TRUE) {
    //$message = "Asesoría registrada con éxito";
    //echo "<script type='text/javascript'>alert('$message');</script>";
    echo "<script type='text/javascript'> document.location = 'carga_exitosa.php?mail=$mail'; </script>";
  } else {
    $message = "Error: " . $query . "<br>" . $conn->error;
    echo "<script type='text/javascript'>alert('$message');</script>";
  }

  $conn->close();
}
?>

<div class="container">
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
  if ($resultado) {
    $resultado->data_seek(0);
    $fila = $resultado->fetch_assoc()
  ?>
  <h4 class="display-4 text-center">Resumen de asesoría con:</h4>
  <br>
  <h4 class="text-center"><?php echo $fila['Alumno']; ?></h4>
  <?php
  } else {
    echo "ERROR: " . $conn->error . "ON: \n";
    echo $query;
  }
  $conn->close();
  ?> 
  <div class="row justify-content-center">
    <div class="col-md-10">
        <div class="row my-4">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
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
                if ($resultado) {
                  $resultado->data_seek(0);
                  $fila = $resultado->fetch_assoc()
                ?>
                <label for="input-escuela">Escuela</label>
                <input type="input-escuela" class="form-control" placeholder="<?php echo $fila['Escuela']; ?>" disabled>
                <label for="input-grado">Grado</label>
                <input type="input-grado" class="form-control" placeholder="<?php echo $fila['Grado']; ?>" disabled>
                <label for="input-grupo">Grupo</label>
                <input type="input-grupo" class="form-control" placeholder="<?php echo $fila['Grupo']; ?>" disabled>
                <?php
                } else {
                  echo "ERROR: " . $conn->error . "ON: \n";
                  echo $query;
                }
                $conn->close();
                ?>

                <?php
                include 'config/Conn.php';
                $query = "SELECT it.descripcion AS integrantes, ta.tipoAsesoria AS tipo, mo.motivo AS motivo
                FROM Integrantes AS it, TipoAsesoria AS ta, Motivo AS mo
                WHERE it.idIntegrantes = $idIntegrantes
                AND ta.idTipoAsesoria = $idTipoAsesoria
                AND mo.idMotivo = $idMotivoAsesoria";
                $resultado = $conn->query($query);
                if ($resultado) {
                  $resultado->data_seek(0);
                  $fila = $resultado->fetch_assoc()
                ?>
                <label for="input-integrantes">Integrantes de la asesoría</label>
                <input type="input-integrantes" class="form-control" placeholder="<?php echo $fila['integrantes'] ?>" disabled>
                <label for="input-tipo">Tipo de asesoría</label>
                <input type="input-tipo" class="form-control" placeholder="<?php echo $fila['tipo'] ?>" disabled>
                <label for="input-motivo">Motivo de asesoría</label>
                <input type="input-motivo" class="form-control" placeholder="<?php echo $fila['motivo'] ?>" disabled>
                <?php
                } else {
                  echo "ERROR: " . $conn->error . "ON: \n";
                  echo $query;
                }
                $conn->close();
                ?> 
                <label for="input-fecha">Fecha</label>
                <input type="input-fecha" class="form-control" placeholder="<?php echo $fecha ?>" disabled>
                <label for="input-observaciones">Observaciones</label>
                <input type="input-observaciones" class="form-control" placeholder="<?php echo $observaciones ?>" disabled>
            </div>
        </div>
      <form method="post" action="" id="insertForm">
        <div class="row my-4 justify-content-center">
          <div class="col-sm-8">
              <button type="submit" class="btn btn-success btn-lg btn-primary btn-block text-uppercase" name="subir" form="insertForm">Subir asesoría</button>
          </div>
        </div>
      </form>
      <div class="row my-4 justify-content-center">
        <div class="col-sm-5">
          <button class="btn btn-danger btn-lg btn-primary btn-block text-uppercase" onclick="window.location.href='asesor_dashboard.php?inputMail=<?php echo $mail; ?>'">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
</div>

</body>

</html>