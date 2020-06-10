<?php include 'asesor_navbar.php';
    $where = "";
    $idAsesor = (int)$_GET['idAsesor'];
    $idAlumno = (int)$_GET['idAlumno'];
    include 'config/Conn.php';
    $queryId = "SELECT correo FROM Asesor WHERE idAsesor = '$idAsesor'";
    $resultadoId = $conn->query($queryId);
    $resultadoId->data_seek(0);
    $filaId = $resultadoId->fetch_assoc();
    $mail = $filaId['correo'];
    $conn->close();
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
  <h4 class="display-4 text-center">Nueva asesoría con:</h4>
  <br>
  <h4 class="text-center"><?php echo $fila['Alumno']; ?></h4>
    <div class="row justify-content-center">
      <div class="col-md-10">
        <form onsubmit="return validateForm()">

        <div class="row my-4">
          <div class="col-sm-2"></div>
          <div class="col-sm-8">
            <label for="input-escuela">Escuela</label>
            <input type="input-escuela" class="form-control" placeholder="<?php echo $fila['Escuela']; ?>" disabled>
            <label for="input-grado">Grado</label>
            <input type="input-grado" class="form-control" placeholder="<?php echo $fila['Grado']; ?>" disabled>
            <label for="input-grupo">Grupo</label>
            <input type="input-grupo" class="form-control" placeholder="<?php echo $fila['Grupo']; ?>" disabled>
          </div>
        </div>
        </form>
            <?php
  } else {
    echo "ERROR: " . $conn->error . "ON: \n";
    echo $query;
  }
              $conn->close();
              ?>
        <div class="row my-4">
          <div class="col-sm-2"></div>
          <div class="col-sm-8">
            <label for="input-integrantes">Seleccione si la asesoría fue:</label>
            <br>
            <form>
              <?php
              include 'config/Conn.php';
              $query = "SELECT ass.idIntegrantes AS id, ass.descripcion AS personas
              FROM Integrantes as ass";
              $resultado = $conn->query($query);

              $resultado->data_seek(0);
              while ($fila = $resultado->fetch_assoc()) {
                ?>
                <input type="radio" name="integrantes" value="<?php echo $fila['id']; ?>"><?php echo $fila['personas']; ?>
                <br>
              <?php } ?>
            </form>
            <?php
            $conn->close();
            ?>
            <div class="col-sm-2"></div>
          </div>
        </div>
        
        
        <div class="row my-4 justify-content-center">
          <div class="col-sm-3">
            <button data-href="tipo_asesoria.php" class="btn btn-success btn-lg btn-primary btn-block text-uppercase">Aceptar</button>
          </div>
          <div class="col-sm-3">
            <button class="btn btn-danger btn-lg btn-primary btn-block text-uppercase" onclick="window.location.href='asesor_dashboard.php?inputMail=<?php echo $mail; ?>'">Cancelar</button>
          </div>
        </div>
      </div>
    </div>
  </div>

<script>
    $(document).ready(function () {
        $(document.body).on("click", "button[data-href]", function () {
          if($('input[name="integrantes"]:checked').val() === undefined) {
            alert("Por favor selecciona una de las opciones");
          } else {
            window.location.href = this.dataset.href
                                 + "?idAsesor=" + <?php echo(json_encode($idAsesor)); ?>
                                 + "&idAlumno=" + <?php echo(json_encode($idAlumno)); ?>
                                 + "&idIntegrantes=" + $('input[name="integrantes"]:checked').val();
          }
            
        });
    });
</script>
  
</body>
</html>