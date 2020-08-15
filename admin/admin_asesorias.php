<?php
include 'navbar_admin.php';

$asesor = new Asesor();
$asesoria = new Asesoria();
$sede = new Sede();

$asesores = $asesor->getAsesores();
$asesoriasTabla = $asesoria->getAsesorias();
$stats = $asesoria->stats();
$sedes = $sede->getSedes();
$turnos = $asesor->getTurnos();

if (isset($_POST['filtrar'])) {
  extract($_POST);
  $where = '';
  // if (!empty($sede)) {
  //   $where .= ' AND Asesor.idAsesor = (SELECT idAsesor FROM ' . $sede;
  // }
  if (!empty($turno)) {
    $where .= ' AND Asesor.idAsesor = (SELECT idAsesor FROM Turno WHERE idTurno = ' . $turno . ')'; 
  }
  if (!empty($asesor)) {
    $where .= ' AND Asesor.idAsesor = ' . $asesor;
  }
  if (isset($filtroFecha)) {
    $where .= " AND Asesoria.fecha BETWEEN '$rangoDeFechasInicio' AND '$rangoDeFechasFin'";
  }

  $asesoriasFiltrado = $asesoria->getAsesorias($where);
  $stats = $asesoria->stats($where);
}

if (isset($asesoriasFiltrado)) {
  $tabla = $asesoriasFiltrado;
} else {
  $tabla = $asesoriasTabla;
}

$total = count($tabla);
$_SESSION['toExport'] = $tabla;

?>

<div class="container">
  <div class="row justify-content-center">
    <h4 class="display-4 text-center">Historial de asesorías</h4>
  </div><!--row-->
  <!-- FILTROS-->
  <div class="row mt-5">
    <h5>FILTROS</h5>
  </div><!--row-->
  <form method="post">
    <div class="row mb-3">
      <div class="col-sm-3">
        <!-- FILTRO ASESOR -->
        <select id="filtroAsesor" class="form-control" name="asesor">
          <option value="" selected>Facilitador</option>
          <?php foreach ($asesores as $fila): ?>
            <?php if (isset($asesor) && $asesor == $fila['idAsesor']): ?>
              <option value="<?=$fila['idAsesor'] ?>" selected><?=$fila['nombre'] ?></option>
            <?php else:?>
              <option value="<?=$fila['idAsesor'] ?>"><?=$fila['nombre'] ?></option>
            <?php endif;?>
          <?php endforeach; ?>
        </select>
      </div><!--col-->
      <div class="col-sm-3">
        <!-- FILTRO SEDE -->
        <select id="filtroSede" class="form-control" name="sede" disabled>
          <option value="" selected>Sede</option>
          <?php foreach ($sedes as $fila): ?>
            <?php if (isset($sede) && $sede == $fila['idLocalidad']): ?>
              <option value="<?=$fila['idLocalidad'] ?>" selected><?=$fila['nombre'] ?></option>
            <?php else: ?>
              <option value="<?=$fila['idLocalidad'] ?>"><?=$fila['nombre'] ?></option>
            <?php endif; ?>
          <?php endforeach; ?>
        </select>
      </div><!--col-->
      <div class="col-sm-6">
        <!-- FILTRO ESCUELA -->
        <select id="filtroEscuela" class="form-control" name="turno">
          <option value="" selected>Escuela (Turno)</option>
          <?php foreach ($turnos as $fila): ?>
            <?php if (isset($turno) && $turno == $fila['idTurno']): ?>
              <option value="<?=$fila['idTurno'] ?>" selected><?=$fila['turno'] ?></option>
            <?php else: ?>
              <option value="<?=$fila['idTurno'] ?>"><?=$fila['turno'] ?></option>
            <?php endif; ?>
          <?php endforeach; ?>
        </select>
      </div><!--col-->
    </div><!--row-->
    <!-- filtros por fecha -->
    <div class="row">
      <h6>FILTRAR POR FECHA</h6>
      <div class="col-sm-12">
        <label class="checkbox-label"><input type="checkbox" name="filtroFecha" id="filtroFecha">
          Activar filtros
        </label>
      </div><!--col-->
    </div><!--row-->
    <div class="row">
      <div class="col-6">
        <div id="rangoDeFechas" class="form-group">
          <input id="rangoDate" type="text" autocomplete="off" class="form-control">
          <input id="resultStart" type="hidden" name="rangoDeFechasInicio">
          <input id="resultEnd" type="hidden" name="rangoDeFechasFin">
        </div>
      </div><!--col-->
      <div class="col-6">
        <button name="filtrar" type="submit" class="btn btn-success">FILTRAR</button>
      </div>
    </div><!--row-->
  </form>         
  <div class="row mt-4">
    <div class="col-sm-6">
      <div class="row d-block">
        <h5>ASESORÍAS</h5>
        <p>Mostrando <strong><?=$total?></strong> resultados</p>
      </div>
    </div><!--col-sm-6-->
    <div class="col-sm-6 align-self-end">
      <form action="exportar_csv.php">
        <div class="row justify-content-end">
          <div class="col-sm-6">
            <button type="submit" name="exportar" class="btn btn-dark btn-block">Exportar</button>
          </div><!--col-->
        </div><!--row-->
      </form>
    </div><!--col-sm-6-->
  </div><!--row-->
  <div class="row mt-4 justify-content-center">
    <div class="table-responsive">
      <table class="table-pagination table table-striped table-sm table-bordered table-dark" 
        style="table-layout: fixed;">
        <thead>
          <th scope="col">Alumno</th>
          <th scope="col">Facilitador</th>
          <th scope="col">Fecha</th>
          <th scope="col">Motivo</th>
          <th scope="col">Dinámica</th>
          <th scope="col">Observaciones</th>
        </thead>
        <tbody>
          <?php foreach ($tabla as $fila): ?>
            <tr>
              <?php if (empty($fila['alumno'])): ?>
              <td><i>ALUMNO BORRADO</i></td>
              <?php else :?>
              <td data-alumno="" data-href="alumno_historial.php" data-id="<?php echo $fila['idAlumno']; ?>" class="align-middle text-truncate"><?php echo $fila['alumno']; ?></td>
              <?php endif; ?>
              <?php if (empty($fila['asesor'])): ?>
              <td><i>ASESOR BORRADO</i></td>
              <?php else :?>
              <td data-asesor="" data-href="asesorias_facilitador.php" data-id="<?php echo $fila['idAsesor']; ?>" class="align-middle text-truncate">
                <?php echo $fila['asesor']; ?>
              </td>
              <?php endif; ?>
              <td class="align-middle text-truncate"><?php echo $fila['fecha']; ?></td>
              <td data-motivo="<?=$fila['motivo']; ?>" class="linkToModal align-middle text-truncate"><?php echo $fila['motivo']; ?></td>
              <td class="align-middle text-truncate"><?php echo $fila['dinamica']; ?></td>
              <td data-obs="<?=$fila['observaciones']; ?>" class="linkToModal align-middle text-truncate"><?php echo $fila['observaciones']; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div><!--table-responsive-->
  </div><!--row-->
  <div class="row mt-4">
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
  </div><!--row--> 
  <div class="row">
    <button class="btn-b aqua-gradient btn-block p-3" onclick="window.location.href='admin_dashboard.php'">
      Regresar
    </button>
    <br>
  </div><!--row-->
</div><!--container-->

<?php include "../modal_obs.php" ?>
<?php include "../modal_motivo.php" ?>
<?php include '../bootstrap_js.php' ?>
<script src="../js/paginacion/tablePagination.js"></script>
<script src="../js/paginacion/index.js"></script>
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