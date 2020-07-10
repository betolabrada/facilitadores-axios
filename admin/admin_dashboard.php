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
require_once '../models/Asesoria.php';

$asesoria = new Asesoria();

// Ultimas asesorias
$u_asesos = $asesoria->ultimasAsesorias();
?>
<div class="container p-5">
  <div class="row p-2">
    <div class="col-md-6">
      <button class="btn-b peach-gradient btn-block p-3" onclick="window.location.href='admin_facilitadores.php'">Facilitadores</button><br>
      <button class="btn-b blue-gradient btn-block p-3" onclick="window.location.href='admin_alumnos.php'">Alumnos</button><br>
    </div>
    <div class="col-md-6">
      <button class="btn-b purple-gradient btn-block p-3" onclick="window.location.href='admin_sedes.php'">Sedes</button><br>
      <button class="btn-b aqua-gradient btn-block p-3" onclick="window.location.href='admin_grupos.php'">Grupos</button><br>
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
          <?php foreach($u_asesos as $fila): ?>
            <tr>
              <td class="align-middle text-truncate"><?php echo $fila['idAsesoria']; ?></td>
              <td class="align-middle text-truncate"><?php echo $fila['alumno']; ?></td>
              <td class="align-middle text-truncate"><?php echo $fila['asesor']; ?></td>
              <td class="align-middle text-truncate"><?php echo $fila['fecha']; ?></td>
              <td class="align-middle text-truncate"><?php echo $fila['motivo']; ?></td>
              <td class="align-middle text-truncate"><?php echo $fila['dinamica']; ?></td>
              <td class="align-middle text-truncate"><?php echo $fila['observaciones']; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <div class="row">
      <button class="btn-b aqua-gradient btn-block p-3" onclick="window.location.href='admin_asesorias.php'">VER TODAS</button><br>
    </div>
  </div>

  <!-- <script>
    $(document).ready(function() {
      $(document.body).on("click", "td[data-alumno]", function() {
        window.location.href = this.dataset.href + "?idAlumno=" + this.dataset.id;
      });
      $(document.body).on("click", "td[data-asesor]", function() {
        window.location.href = this.dataset.href + "?idUsuario=" + this.dataset.id;
      });
    });
  </script> -->

  </body>

  </html>