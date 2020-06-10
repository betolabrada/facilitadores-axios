<style>
  td[data-href] {
    cursor: pointer;
  }

  td[data-href]:hover {
    background-color: #33a652;
  }
</style>

<?php
include 'navbar_admin.php';
?>
<div class="container p-5">
  <div class="row p-2">
    <div class="col-md-6">
      <button class="btn-b peach-gradient btn-block p-3" onclick="window.location.href='admin_sedes.php'">Sedes</button><br>
      <button class="btn-b blue-gradient btn-block p-3" onclick="window.location.href='admin_facilitadores.php'">Facilitadores</button>
    </div>
    <div class="col-md-6">
      <button class="btn-b purple-gradient btn-block p-3">Escuelas</button><br>
      <button class="btn-b aqua-gradient btn-block p-3">---</button>
    </div>
  </div>
</div>
<div class="container">
  <div class="row">
    <h5>ÚLTIMAS ASESORÍAS</h5>
    <div class="table-responsive">
      <table class="table table-striped table-dark table-sm table-bordered" style="table-layout: fixed;">
        <thead>
          <th scope="col">ID</th>
          <th scope="col">Alumno</th>
          <th scope="col">Facilitador</th>
          <th scope="col">Fecha</th>
          <th scope="col">Motivo</th>
          <th scope="col">Dinámica</th>
          <th scope="col">Observaciones</th>
        </thead>
        <tbody>
          <?php
          include '../config/Conn.php';
          $query = "SELECT 
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

          $resultado = $conn->query($query);
          if (!$resultado) {
            echo "ERROR: " . $conn->error;
          }
          if (!$resultado->fetch_array()) {
            echo "<tr><td colspan='5'>AUN NO HAY ASESORIAS REGISTRADAS</td></tr>";
          } else {

            $resultado->data_seek(0);

            while ($fila = $resultado->fetch_assoc()) {
          ?>
              <tr>
                <td class="align-middle text-truncate"><?php echo $fila['idAsesoria']; ?></td>
                <td class="align-middle text-truncate"><?php echo $fila['alumno']; ?></td>
                <td class="align-middle text-truncate"><?php echo $fila['asesor']; ?></td>
                <td class="align-middle text-truncate"><?php echo $fila['fecha']; ?></td>
                <td class="align-middle text-truncate"><?php echo $fila['motivo']; ?></td>
                <td class="align-middle text-truncate"><?php echo $fila['dinamica']; ?></td>
                <td class="align-middle text-truncate"><?php echo $fila['observaciones']; ?></td>
              </tr>
          <?php
            }
          }
          $conn->close();
          ?>
        </tbody>
      </table>
    </div>
    <div class="row">
      <button class="btn-b aqua-gradient btn-block p-3" onclick="window.location.href='admin_asesorias.php'">VER TODAS</button><br>
    </div>
  </div>
  </body>
  </html>