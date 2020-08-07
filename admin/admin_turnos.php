<?php 
  include 'navbar_admin.php'; 

  $asesor_model = new Asesor();

  $turnos = $asesor_model->getTurnos();
  
?>
<div class="container">
  <div class="row">
    <div class="col-lg-12 text-center">
      <h5 class="display-4 text-center">TURNOS</h5>
    </div>
  </div>
</div>

<div class="container text-center">
  <div class="row">
    <br>
    <div class="table-responsive">
      <table class="table table-striped table-dark table-sm table-bordered">
        <thead>
          <th scope="col">Turno</th>
          <th scope="col">Asesor</th>
          <th scope="col">Cambiar</th>
          <th scope="col">Eliminar</th>
        </thead>
        <tbody>
          <?php foreach ($turnos as $fila): ?>
            <tr>
              <td class="align-middle"><?=$fila['turno']; ?></td>
              <td class="align-middle"><?=$fila['nombreAsesor']; ?></td>
              <td class="align-middle">
                <a role="button" 
                  href="editar_turno.php?idTurno=<?=$fila['idTurno']; ?>" 
                  class=" btn btn-info">Cambiar
                </a>
              </td>
              <td class="align-middle">
                <a role="button" 
                  href="borrar_turno.php?idTurno=<?=$fila['idTurno']?>" 
                  class=" btn btn-danger">Eliminar
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
  <div class="col-lg-2">
    <div class="row">
      <button class="btn-b aqua-gradient btn-block p-3" onclick="window.location.href='admin_dashboard.php'">Regresar</button><br>
    </div>
  </div>
</div>


</body>
</html>