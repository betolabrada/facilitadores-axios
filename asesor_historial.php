<?php 
include 'asesor_navbar.php';

// Traemos modelo de Asesor para los queries y lo instanciamos
require_once 'models/Asesor.php';
$asesor_model = new Asesor();

// Leemos parametro de idAsesor para obtener el asesor actual
$idAsesor = (int) $_GET['id'];
$asesor = $asesor_model->getAsesorById($idAsesor);

// Arreglo de meses para el select
$meses = array('Selecciona Mes', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 
  'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

// Default: mes es 0 y las asesorias no llevan filtro
$mes = 0;
$asesoriasDeAsesor = $asesor_model->getAsesorias($idAsesor);

// Si el filtro se aplica llamar al query con el numero de mes, si es 0 no hacer nada
if (isset($_GET['filtrar'])) {
  if ($_GET['mes'] > 0) {
    // Cambiamos variable de mes
    $mes = $_GET['mes'];
    $asesoriasDeAsesor = $asesor_model->getAsesorias($idAsesor, $mes);
  }
}
$_SESSION['toExport'] = $asesoriasDeAsesor;

?>

<div class="container">
  <h4 class="display-4 text-center">Historial de asesorías</h4>
  <h3 class="text-center mt-4"><?=$asesor['nombre']?></h3>
  <!-- FILTROS-->
  <div class="row">
    <h5>FILTROS</h5>
  </div><!--row-->
  <form>
    <input type="hidden" name="idAsesor" value="<?=$idAsesor?>">
    <div class="row mb-3">
      <div class="col-sm-3">
        <!-- FILTRO MES -->
        <select id="filtroMes" class="form-control" name="mes">
          <?php foreach ($meses as $k => $v): ?>              
            <option value="<?=$k?>" <?=$mes == $k ? 'selected' : ''?>><?=$v?></option>
          <?php endforeach; ?>
        </select>
      </div><!--col-->
      <div class="col-sm-1">
        <button class="btn btn-success" type="submit" name="filtrar" value="Filtrar">Filtrar</button>
      </div><!--col-->
      <div class="col-sm-1">
        <button class="btn btn-success" type="submit" name="exportar"
        formaction="admin/exportar_csv.php" value="Exportar">Exportar</button>
      </div><!--col-->
    </div><!--row-->
  </form>
  <div class="row">
    <h5>ASESORÍAS</h5>
    <div class="table-responsive">
      <table class="table-pagination table table-striped table-dark table-sm table-bordered" 
        style="table-layout: fixed;">
        <thead>
          <th scope="col">Alumno</th>
          <th scope="col">Fecha</th>
          <th scope="col">Motivo</th>
          <th scope="col">Dinámica</th>
          <th scope="col">Observaciones</th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
        </thead>
        <tbody>
          <?php foreach ($asesoriasDeAsesor as $fila): ?>
            <tr>
              <td data-href="alumno_historial.php" data-id="<?php echo $fila['idAlumno']; ?>" class="align-middle text-truncate"><?php echo $fila['Alumno']; ?></td>
              <td class="align-middle text-truncate"><?php echo $fila['Fecha']; ?></td>
              <td data-motivo="<?=$fila['Motivo']; ?>" class="linkToModal align-middle text-truncate"><?php echo $fila['Motivo']; ?></td>
              <td class="align-middle text-truncate"><?php echo $fila['Dinamica']; ?></td>
              <td data-obs="<?=$fila['Observaciones']; ?>" class="linkToModal align-middle text-truncate"><?php echo $fila['Observaciones']; ?></td>
              <td class="align-middle">
                <form action="admin/confirmar_editar_asesoria.php" method="POST">
                  <input type="number" name="idAsesoria" value="<?php echo $fila['idAsesoria']?>" hidden="hidden"/>
                  <input type="text" name="nombreAlumno" value="<?php echo $fila['Alumno']?>" hidden="hidden"/>
                  <input type="submit" value="Editar" class=" btn btn-danger"/>
                </form>
              </td>
              <td class="align-middle">
                <form action="admin/confirmar_borrar_asesoria.php" method="POST">
                  <input type="number" name="idAsesoria" value="<?php echo $fila['idAsesoria']?>" hidden="hidden"/>
                  <input type="text" name="nombreAlumno" value="<?php echo $fila['Alumno']?>" hidden="hidden"/>
                  <input type="submit" value="Eliminar" class=" btn btn-danger"/>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div><!--table-responsive-->
  </div><!--row-->
  <div class="row">
    <button class="btn-b aqua-gradient btn-block p-3" 
      onclick="window.location.href='asesor_dashboard.php?inputMail=<?php echo $mail; ?>'">REGRESAR
    </button><br>
  </div><!--row-->
</div><!--container-->

<?php include "modal_obs.php" ?>
<?php include "modal_motivo.php" ?>

<script src="js/paginacion/tablePagination.js"></script>
<script src="js/paginacion/index.js"></script>

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