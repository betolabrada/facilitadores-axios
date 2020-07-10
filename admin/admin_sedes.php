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
require_once '../models/Sede.php';

$asesor_model = new Asesor;
$sede_model = new Sede;

$asesores = $asesor_model->getAsesores();
$sedes = $sede_model->getSedes();
$escuelas_sedes = $sede_model->getEscuelaLocalidad();

$where = "WHERE TRUE";

$asesor = !empty($_POST['asesor']) ? $_POST['asesor'] : "";
$sede = !empty($_POST['sede']) ? $_POST['sede'] : "";

if (isset($_POST['filtrar'])) {
  if ($asesor) $where .= " AND Asesor.nombre = '" . $asesor . "' ";
  if ($sede) $where .= " AND Localidad.idLocalidad = " . $sede . " ";
}
?>

<div class="container">
  <div class="row">
      <div class="col-lg-12 text-center">
          <h5 class="display-4 text-center">Escuelas y Localidades </h5>
      </div>
  </div>
  <br>
  <br>
  <div class="row justify-content-center">
    <form method="POST">
      <div class="row mb-3 justify-content-center">
        <div class="col-sm-12 text-center">
          <h5>FILTROS</h5>
        </div>
        <div class="col-sm-3">
          <!-- FILTRO ASESOR -->
          <select id="filtroAsesor" class="form-control" name="asesor">
            <option value="" selected>Facilitador</option>
            <?php foreach ($asesores as $fila): ?>
            <?php if (isset($post_asesor) && $post_asesor == $fila['idAsesor']): ?>
            <option value="<?=$fila['idAsesor'] ?>" selected><?=$fila['nombre'] ?></option>
            <?php else:?>
            <option value="<?=$fila['idAsesor'] ?>"><?=$fila['nombre'] ?></option>
            <?php endif;?>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-sm-3">
          <!-- FILTRO SEDE -->
          <select id="filtroSede" class="form-control" name="sede">
            <option value="" selected>Sede</option>
            <?php foreach ($sedes as $fila): ?>
              <?php if (isset($post_sede) && $post_sede == $fila['idLocalidad']): ?>
                <option value="<?=$fila['idLocalidad'] ?>" selected><?=$fila['nombre'] ?></option>
              <?php else: ?>
                <option value="<?=$fila['idLocalidad'] ?>"><?=$fila['nombre'] ?></option>
              <?php endif; ?>
            <?php endforeach; ?>
          </select>
        </div>

      </div>
      <div class="row">
        <div class="col-sm-12 text-center">
          <button name="filtrar" type="submit" class="btn btn-success">FILTRAR</button>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="container">
  <br>
  <div class="row">
    <div class="table-responsive">
    <table class="table table-striped table-dark table-sm table-bordered" style="table-layout: fixed;">
        <thead>
          <th scope="col">Nombre</th>
          <th scope="col">Localidad</th>
        </thead>
        <tbody>
          <?php foreach ($escuelas_sedes as $fila): ?>
            <tr>
              <td data-escuela="" data-href="admin_datos_escuela.php" data-id="<?php echo $fila['idEscuela']; ?>" class="align-middle text-truncate"><?php echo $fila['Escuela']; ?></td>
              <td data-sede="" data-href="admin_datos_sede.php" data-id="<?php echo $fila['idSede']; ?>" class="align-middle text-truncate"><?php echo $fila['Sede']; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
</div>
<div class="row justify-content-center">
    <div class="row my-12">
        <div class="col-sm-12">
            <button class="btn btn-danger btn-lg btn-primary btn-block text-uppercase" onclick="window.location.href='admin_dashboard.php'">Cancelar</button>
        </div>
    </div>
  </div>
  <br>
</div>

<script>
    $(document).ready(function () {
        $(document.body).on("click", "td[data-escuela]", function () {
            window.location.href = this.dataset.href + "?idEscuela=" + this.dataset.id;
        });
        $(document.body).on("click", "td[data-sede]", function () {
            window.location.href = this.dataset.href + "?idSede=" + this.dataset.id;
        });
    });
</script>
</body>
</html>