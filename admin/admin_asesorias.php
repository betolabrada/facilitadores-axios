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
require_once '../models/Asesor.php';
require_once '../models/Asesoria.php';
require_once '../models/Sede.php';
require_once '../models/Escuela.php';

// echo basename(__FILE__);

$asesor = new Asesor();
$asesoria = new Asesoria();
$sede = new Sede();
$escuela = new Escuela();

$asesores = $asesor->getAsesores();
$asesoriasTabla = $asesoria->getAsesoriasTabla();
$stats = $asesoria->stats();
$sedes = $sede->getSedes();
$escuelas = $escuela->getEscuelas();

if (isset($_POST['filtrar'])) {
  $where = "";

  $post_asesor = $_POST['asesor'];
  $post_sede = $_POST['sede'];
  $post_escuela = $_POST['escuela'];
  $rangoDeFechasInicio = $_POST['rangoDeFechasInicio'];
  $rangoDeFechasFin = $_POST['rangoDeFechasFin'];

  if ($post_asesor) $where .= " AND Asesor.idAsesor = '$post_asesor'";
  if ($post_sede) $where .= " AND Localidad.idLocalidad = '$post_sede'";
  if ($post_escuela) $where .= " AND Escuela.idEscuela = " . $post_escuela . " ";
  if (isset($_POST['filtroFecha']) && $rangoDeFechasInicio && $rangoDeFechasFin) {
    $where .= " AND Asesoria.fecha BETWEEN '$rangoDeFechasInicio' AND '$rangoDeFechasFin'";
  }

  $asesoriasFiltrado = $asesoria->getAsesoriasTabla($where);
  $stats = $asesoria->stats($where);
}

if (isset($asesoriasFiltrado)) {
  $tabla = $asesoriasFiltrado;
} else {
  $tabla = $asesoriasTabla;
}

$number_of_pages = ceil(count($tabla) / 10);
?>

<div class="container">
  <h4 class="display-4 text-center">Historial de asesorías</h4>
  <?php require_once '../utils/form_filtros.php'; ?>

  <div class="row mt-4">
    <div class="col-sm-6">
      <div class="row d-block">
        <h5>ASESORÍAS</h5>
        <p>Mostrando <strong><?=count($tabla) ?></strong>  resultados</p>
      </div>
    </div><!--col-sm-6-->
    <div class="col-sm-6">
    <form action="exportar_csv.php" method="post">
    <?php if (isset($where)) :?>
    <input type="hidden" name="filters" value="<?=$where?>">
    <?php endif;?>
      <div class="row justify-content-end">
        <div class="col-sm-6">
          <button type="submit" name="exportar" class="btn btn-warning btn-block">Exportar CSV</button>
        </div>
        <div class="col-sm-6">
          <button type="submit" name="exportar_todo" class="btn btn-secondary btn-block">Exportar Todo</button>
        </div>
      </div>
    </form>
    </div><!--col-sm-6-->

    
    <div class="table-responsive">
    <table class="table table-striped table-dark table-sm table-bordered" style="table-layout: fixed;">
        <thead>
          <th scope="col">Alumno</th>
          <th scope="col">Facilitador</th>
          <th scope="col">Fecha</th>
          <th scope="col">Motivo</th>
          <th scope="col">Dinámica</th>
          <th scope="col">Observaciones</th>
        </thead>
        <tbody id="pagination">
          <?php foreach ($tabla as $fila): ?>
            <tr>
              <td data-alumno="" data-href="alumno_historial.php" data-id="<?php echo $fila['idAlumno']; ?>" class="align-middle text-truncate"><?php echo $fila['alumno']; ?></td>
              <td data-asesor="" data-href="asesorias_facilitador.php" data-id="<?php echo $fila['idAsesor']; ?>" class="align-middle text-truncate"><?php echo $fila['asesor']; ?></td>
              <td class="align-middle text-truncate"><?php echo $fila['fecha']; ?></td>
              <td data-motivo="<?=$fila['motivo']; ?>" class="linkToModal align-middle text-truncate"><?php echo $fila['motivo']; ?></td>
              <td class="align-middle text-truncate"><?php echo $fila['dinamica']; ?></td>
              <td data-obs="<?=$fila['observaciones']; ?>" class="linkToModal align-middle text-truncate"><?php echo $fila['observaciones']; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <div class="col-md-12 text-center">
      <ul class="pagination pagination-lg pager" id="pagination_page"></ul>
    </div>

    <h5>ESTADÍSTICAS</h5>
    <div class="table-responsive">
    <table class="table table-striped table-dark table-sm table-bordered" style="table-layout: fixed;">
        <thead>
          <th scope="col">Total de asesorías</th>
          <th scope="col">Total de alumnos atendidos</th>
          <th scope="col">Total de asesorías con alumnos</th>
          <th scope="col">Total de asesorías con padres</th>
        </thead>
        <tbody>
          <tr>
            <td class="align-middle text-truncate"><?php echo $stats['totalAsesorias']; ?></td>
            <td class="align-middle text-truncate"><?php echo $stats['totalAlumnos']; ?></td>
            <td class="align-middle text-truncate"><?php echo $stats['totalConAlumno']; ?></td>
            <td class="align-middle text-truncate"><?php echo $stats['totalConPadres']; ?></td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="row">
      <button class="btn-b aqua-gradient btn-block p-3" onclick="window.location.href='admin_dashboard.php'">
        Regresar
      </button>
      <br>
    </div>

  </div>
</div>

<?php include "../modal_obs.php" ?>
<?php include "../modal_motivo.php" ?>

<script src="../paginacion/bootstrap-table-pagination.js"></script>
<script src="../paginacion/pagination.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
  $(document).ready(function() {
    $(document.body).on("click", "td[data-alumno]", function() {
      window.location.href = this.dataset.href + "?idAlumno=" + this.dataset.id;
    });
    $(document.body).on("click", "td[data-asesor]", function() {
      window.location.href = this.dataset.href + "?idUsuario=" + this.dataset.id;
    });
    $(document.body).on("click", "td[data-motivo]", function() {
      $("#modalMotivo .modal-body").html(this.dataset.motivo);
      $("#modalMotivo").modal("show");
    });
    $(document.body).on("click", "td[data-obs]", function() {
      $("#modalObservacion .modal-body").html(this.dataset.obs);
      $("#modalObservacion").modal("show");
    });
  });
</script>

<script src="../js/filtrosPorFecha.js"></script>

</body>

</html>