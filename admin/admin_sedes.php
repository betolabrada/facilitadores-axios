<?php
include 'navbar_admin.php';

$sede_model = new Sede();
$escuela_model = new Escuela();

$sedes = $sede_model->getSedes();
$escuelas_sedes = $sede_model->getEscuelaLocalidad();

$idSede = !empty($_POST['sede']) ? $_POST['sede'] : "";

if (isset($_POST['filtrar'])) {
  $escuelas_sedes = $sede_model->getEscuelaLocalidad($idSede); 
}
?>

<div class="container">
  <div class="row mb-3">
    <div class="col-12 text-center">
      <h5 class="display-4 text-center">Escuelas y Localidades </h5>
    </div><!--col-->
  </div><!--row-->
  <form method="POST">
    <div class="row justify-content-center">
      <div class="col-sm-12 text-center">
        <h5>FILTRAR</h5>
      </div><!--col-->
      <div class="col-sm-3">
        <!-- FILTRO SEDE -->
        <select id="filtroSede" class="form-control" name="sede">
          <option value="" selected>Sede</option>
          <?php foreach ($sedes as $fila): ?>
          <?php if (isset($idSede) && $idSede == $fila['idLocalidad']): ?>
          <option value="<?=$fila['idLocalidad'] ?>" selected><?=$fila['nombre'] ?></option>
          <?php else: ?>
          <option value="<?=$fila['idLocalidad'] ?>"><?=$fila['nombre'] ?></option>
          <?php endif; ?>
          <?php endforeach; ?>
        </select>
      </div><!--col-->
    </div><!--row-->
    <div class="row">
      <div class="col-sm-12 text-center">
        <button name="filtrar" type="submit" class="btn btn-success">FILTRAR</button>
      </div>
    </div><!--row-->
  </form>
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
    </div><!--table-responsive-->
  </div><!--row-->
  <div class="row justify-content-center">
    <div class="col-sm-4">
        <button class="btn btn-success btn-lg btn-primary btn-block text-uppercase" onclick="window.location.href='admin_nueva_escuela.php'">Nueva Escuela</button>
    </div><!--col-->
    <div class="col-sm-4">
        <button class="btn btn-success btn-lg btn-primary btn-block text-uppercase" onclick="window.location.href='confirmar_agregar_localidad.php'">Nueva Localidad</button>
    </div><!--col-->
  </div><!--row-->
</div><!--container-->

<?php include '../bootstrap_js.php' ?>

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