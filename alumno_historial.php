<?php
include 'asesor_navbar.php';

require_once 'models/Alumno.php';
require_once 'models/Asesor.php';
require_once 'models/Asesoria.php';

$alumno_model = new Alumno;
$asesor_model = new Asesor;
$asesoria_model = new Asesoria;

$idAlumno = (int)$_GET['idAlumno'];
$idAsesor = (int)$_GET['idAsesor'];

$asesoria_alumno = $asesoria_model->getAsesoriasDeAlumno($idAlumno);

$asesor = $asesor_model->getAsesorById($idAsesor);
$alumno = $alumno_model->getAlumnoById($idAlumno);

$mail = $asesor['correo'];

$where = "WHERE Alumno.idAlumno = $idAlumno";
if (isset($_POST['filtrar'])) {
    if ($_POST['mes']) {
        $where .= " AND MONTH(Asesoria.fecha) = " . $_POST['mes'];
    }    
}

?>

<div class="container">
  <h4 class="display-4 text-center">Historial de asesorías</h4>
  <br>
  <h4 class="text-center">Historial de alumno:<br /><?=$alumno['Alumno']?></h4>
  <br>
  <div class="row">
    <h5>ASESORÍAS</h5>
    <div class="table-responsive">
      <table class="table-pagination table table-striped table-dark table-sm table-bordered" 
        style="table-layout: fixed;">
        <thead>
          <th scope="col">Fecha</th>
          <th scope="col">Motivo</th>
          <th scope="col">Dinámica</th>
          <th scope="col">Observaciones</th>
        </thead>
        <tbody>
          <?php foreach ($asesoria_alumno as $fila): ?>
            <tr>
              <td class="align-middle text-truncate"><?php echo $fila['Fecha']; ?></td>
              <td data-motivo="<?=$fila['Motivo']; ?>" class="linkToModal align-middle text-truncate"><?php echo $fila['Motivo']; ?></td>
              <td class="align-middle text-truncate"><?php echo $fila['Dinamica']; ?></td>
              <td data-obs="<?=$fila['Observaciones']; ?>" class="linkToModal align-middle text-truncate"><?php echo $fila['Observaciones']; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div><!--table-responsive-->

    <div class="row">
      <button class="btn-b purple-gradient btn-block p-3" 
        onclick="window.location.href='asesor_historial.php?id=<?php echo $idAsesor; ?>'"
      >Regresar
      </button>
      <br>
    </div>
  </div>
</div>

<script src="js/paginacion/tablePagination.js"></script>
<script src="js/paginacion/pagination.js"></script>

<?php include "modal_obs.php" ?>
<?php include "modal_motivo.php" ?>

<script>
    $(document).ready(function() {
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