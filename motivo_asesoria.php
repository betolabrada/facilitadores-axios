<?php include 'asesor_navbar.php';
    $where = "";
    $idAsesor = (int)$_GET['idAsesor'];
    $idAlumno = (int)$_GET['idAlumno'];
    $idIntegrantes = (int)$_GET['idIntegrantes'];
    $idTipoAsesoria = (int)$_GET['idTipoAsesoria'];
    include 'config/Conn.php';
    $queryId = "SELECT correo FROM Asesor WHERE idAsesor = '$idAsesor'";
    $resultadoId = $conn->query($queryId);
    $resultadoId->data_seek(0);
    $filaId = $resultadoId->fetch_assoc();
    $mail = $filaId['correo'];
    $conn->close();
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
        if ($resultado) {
          $resultado->data_seek(0);
          $fila = $resultado->fetch_assoc();
        
        ?>
          <h4 class="display-4 text-center">Nueva asesoría con:</h4>
          <br>
          <h4 class="text-center"><?php echo $fila['Alumno']; ?></h4>
          <br>
          <form onsubmit="return validateForm()">
   
        <?php
        }
        $conn->close();
        ?>
        <center>
          <label for="input-tipo">Motivo de Asesoría</label>
        </center>
        <div class="row justify-content-center">
          <div class="col-md-8">
            <div class="row">
              <select id="motivoAsesoria" class="form-control">
              <?php
              include 'config/Conn.php';
              $query = "SELECT m.idMotivo AS id, m.motivo AS motivo
              FROM Motivo as m
              WHERE m.idTipoAsesoria = $idTipoAsesoria";
              $resultado = $conn->query($query);

              $resultado->data_seek(0);
              while ($fila = $resultado->fetch_assoc()) {
                ?>
                <option value="<?php echo $fila['id']; ?>"><?php echo $fila['motivo']; ?></option>
              <?php } ?>
              
              </select>
              <br>
              <?php
              $conn->close();
              ?>
            </div>
          </div>
        </div>
        </form>
        
        
        <div class="row my-4 justify-content-center">
          <div class="col-sm-3">
            <button data-href="fobs_asesoria.php" class="btn btn-success btn-lg btn-primary btn-block text-uppercase">Aceptar</button>
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
            window.location.href = this.dataset.href
                                 + "?idAsesor=" + <?php echo(json_encode($idAsesor)); ?>
                                 + "&idAlumno=" + <?php echo(json_encode($idAlumno)); ?>
                                 + "&idIntegrantes=" + <?php echo(json_encode($idIntegrantes)); ?>
                                 + "&idTipoAsesoria=" + <?php echo(json_encode($idTipoAsesoria)); ?>
                                 + "&idMotivoAsesoria=" + document.getElementById('motivoAsesoria').value;
        });
    });
</script>
</body>
</html>