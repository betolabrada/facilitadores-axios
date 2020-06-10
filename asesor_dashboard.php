<?php include 'asesor_navbar.php';

$where = "";
$idAsesor = "";
$mail = $_GET['inputMail'];
include 'config/Conn.php';
$queryId = "SELECT idAsesor FROM Asesor WHERE correo = '$mail'";
$resultadoId = $conn->query($queryId);
if ($resultadoId) {
  $resultadoId->data_seek(0);
  $filaId = $resultadoId->fetch_assoc();
  $idAsesor = $filaId['idAsesor'];
} else {
  echo "ERROR: " . $conn->error;
}
$conn->close();
?>

<div class="container p-5">
  <div class="row p-2">
    <div class="col-md-6">
      <button class="btn-b peach-gradient btn-block p-3" onclick="window.location.href='registro_aseso.php?id=<?php echo $idAsesor; ?>'">Registrar Asesoría</button>
    </div>
    <div class="col-md-6">
      <button class="btn-b purple-gradient btn-block p-3" onclick="window.location.href='asesor_historial.php?id=<?php echo $idAsesor; ?>'">Historial</button><br>
    </div>
  </div>
</div>
<div class="container">
  <div class="row">
    <h5>ÚLTIMAS ASESORÍAS</h5>
      <div class="table-responsive">
          <table class="table table-striped table-dark table-sm table-bordered" style="table-layout: fixed;">
              <thead>
                  <th scope="col">Alumno</th>
                  <th scope="col">Fecha</th>
                  <th scope="col">Motivo</th>
                  <th scope="col">Dinámica</th>
                  <th scope="col">Observaciones</th>
              </thead>
              <tbody>
                <?php
                  include 'config/Conn.php';
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
                  WHERE Asesor.idAsesor = $idAsesor
                  ORDER BY Asesoria.idAsesoria DESC 
                  LIMIT 5";

                  $resultado = $conn->query($query);
                  if (!$resultado) {
                    echo "ERROR: " . $conn->error;
                  }
                  if(!$resultado->fetch_array()){
                      echo "<tr><td colspan='5'>AUN NO HAY ASESORIAS REGISTRADAS</td></tr>";
                  }else{
                      
                  $resultado->data_seek(0);
                  
                  while ($fila = $resultado->fetch_assoc()) {
                      ?>
                      <tr>
                          <td data-href="alumno_historial.php" data-id="<?php echo $fila['id']; ?>" class="align-middle text-truncate"><?php echo $fila['Alumno']; ?></td>
                          <td class="align-middle text-truncate"><?php echo $fila['Fecha']; ?></td>
                          <td class="align-middle text-truncate"><?php echo $fila['Motivo']; ?></td>
                          <td class="align-middle text-truncate"><?php echo $fila['Dinamica']; ?></td>
                          <td class="align-middle text-truncate"><?php echo $fila['Observaciones']; ?></td>
                      </tr>
                  <?php
                  }
                }
                    $conn->close();
                ?>
              </tbody>
          </table>
      </div>
      <button class="btn-b aqua-gradient btn-block p-3" onclick="window.location.href='asesor_historial.php?id=<?php echo $idAsesor; ?>'">VER TODAS</button>
    </div>
  </div>

  <script>
    $(document).ready(function () {
        $(document.body).on("click", "td[data-href]", function () {
          window.location.href = this.dataset.href + "?idAsesor=" + <?php echo(json_encode($idAsesor)); ?> + "&idAlumno="+ this.dataset.id;
        });
    });
  </script>
  </body>
  </html>