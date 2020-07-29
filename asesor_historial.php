<?php 
if (isset($_SESSION['admin'])) {
  include 'admin/navbar_admin.php';
} else {
  include 'asesor_navbar.php';
}

require_once 'models/Asesor.php';
require_once 'models/Asesoria.php';

$asesor_model = new Asesor();
$asesoria_model = new Asesoria();

$idAsesor = (int) $_GET['id'];

$asesor = $asesor_model->getAsesorById($idAsesor);
$asesoriasDeAsesor = $asesoria_model->getAsesoriasDeAsesor($idAsesor);

$mail = $_SESSION['user'];

?>

<div class="container">
  <h4 class="display-4 text-center">Historial de asesorías</h4>
  <h3 class="text-center mt-4"><?=$asesor['nombre']?></h3>
  <?php include 'utils/form_filtros.php'; ?>
    <div class="row">
      <h5>ASESORÍAS</h5>

      <div class="table-responsive">
        <table class="table table-striped table-dark table-sm table-bordered" style="table-layout: fixed;">
          <thead>
              <th scope="col">Alumno</th>
              <th scope="col">Fecha</th>
              <th scope="col">Motivo</th>
              <th scope="col">Dinámica</th>
              <th scope="col">Observaciones</th>
              <th>&nbsp;</th>
              <th>&nbsp;</th>
          </thead>
          <tbody id="pagination">
            <?php foreach ($asesoriasDeAsesor as $fila): ?>
              <tr>
                  <td data-href="alumno_historial.php" data-id="<?php echo $fila['id']; ?>" class="align-middle text-truncate"><?php echo $fila['Alumno']; ?></td>
                  <td class="align-middle text-truncate"><?php echo $fila['Fecha']; ?></td>
                  <td data-motivo="<?=$fila['Motivo']; ?>" class="linkToModal align-middle text-truncate"><?php echo $fila['Motivo']; ?></td>
                  <td class="align-middle text-truncate"><?php echo $fila['Dinamica']; ?></td>
                  <td data-obs="<?=$fila['Observaciones']; ?>" class="linkToModal align-middle text-truncate"><?php echo $fila['Observaciones']; ?></td>
                  <td class="align-middle">
                      <form action="admin/asesoria/confirmar_editar_asesoria.php" method="POST">
                          <input type="number" name="idAsesoria" value="<?php echo $fila['id']?>" hidden="hidden"/>
                          <input type="text" name="nombreAlumno" value="<?php echo $fila['Alumno']?>" hidden="hidden"/>
                          <input type="submit" value="Editar" class=" btn btn-danger"/>
                      </form>
                  </td>
                  <td class="align-middle">
                      <form action="admin/asesoria/confirmar_borrar_asesoria.php" method="POST">
                          <input type="number" name="idAsesoria" value="<?php echo $fila['id']?>" hidden="hidden"/>
                          <input type="text" name="nombreAlumno" value="<?php echo $fila['Alumno']?>" hidden="hidden"/>
                          <input type="submit" value="Eliminar" class=" btn btn-danger"/>
                      </form>
                  </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <div class="col-md-12 text-center">
          <ul class="pagination pagination-lg pager" id="pagination_page"></ul>
      </div>

      <div class="row">
          <button class="btn-b aqua-gradient btn-block p-3" onclick="window.location.href='asesor_dashboard.php?inputMail=<?php echo $mail; ?>'">REGRESAR</button><br>
      </div>
    </div>
</div>

<?php include "modal_obs.php" ?>
<?php include "modal_motivo.php" ?>

<script src="paginacion/bootstrap-table-pagination.js"></script>
<script src="paginacion/pagination.js"></script>

<script>
    $(document).ready(function() {
        $(document.body).on("click", "td[data-href]", function() {
            window.location.href = this.dataset.href + "?idAsesor=" + <?php echo (json_encode($idAsesor)); ?> + "&idAlumno=" + this.dataset.id;
        });
        $(document.body).on("click", "td[data-obs]", function() {
            $("#modalObservacion .modal-body").html(this.dataset.obs);
            $("#modalObservacion").modal("show");
        });
        $(document.body).on("click", "td[data-motivo]", function() {
            $("#modalMotivo .modal-body").html(this.dataset.motivo);
            $("#modalMotivo").modal("show");
        });  
    });
</script>

</body>

</html>