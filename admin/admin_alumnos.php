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
require_once '../models/Alumno.php';

$alumno_model = new Alumno();

$alumnos = $alumno_model->getAlumnos();

$where = "WHERE TRUE";

$asesor = !empty($_POST['asesor']) ? $_POST['asesor'] : "";
$sede = !empty($_POST['sede']) ? $_POST['sede'] : "";
$escuela = !empty($_POST['escuela']) ? $_POST['escuela'] : "";

if (isset($_POST['filtrar'])) {
  if ($asesor) $where .= " AND ase.nombre = '" . $asesor . "' ";
  if ($sede) $where .= " AND l.idLocalidad = " . $sede . " ";
  if ($escuela) $where .= " AND e.idEscuela = " . $escuela . " ";
}
?>

<div class="container">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h5 class="display-4 text-center">Alumnos</h5>
        </div>
    </div>
    <br>
  <br>
  <?php require_once '../utils/form_filtros_alumno.php'; ?>

</div>

<div class="container">
  <br>
  <h4 class="text-center">Escriba el nombre del alumno</h4>
  <div class="row justify-content-center">
      <input id="search" type="text" size="50" style="text-align:center;" placeholder="Escriba aquí">
  </div>
  <br>
  <div class="row justify-content-center">
    <div class="row my-12 justify-content-center">
        <div class="col-sm-7">
            <button class="btn btn-success btn-lg btn-primary btn-block text-uppercase" onclick="window.location.href='admin_registrar_alumno.php'">Nuevo alumno</button>
        </div>
        <div class="col-sm-5">
            <button class="btn btn-danger btn-lg btn-primary btn-block text-uppercase" onclick="window.location.href='admin_dashboard.php'">Cancelar</button>
        </div>
    </div>
  </div>
  <br>
  <div class="row justify-content-center">
    <div class="col-md-10">
        <table id="houdini" class="table table-striped table-dark table-sm table-bordered" style="visibility: collapse;">
          <thead>
            <th scope="col">Alumno</th>
            <th scope="col">Escuela</th>
            <th scope="col">Grado</th>
            <th scope="col">Grupo</th>
          </thead>
          <tbody id="filter"> 
            <?php foreach ($alumnos as $fila): ?>
              <tr>
                <td data-href="admin_datos_alumno.php" data-id="<?php echo $fila['id']; ?>" class="align-middle"><?php echo $fila['Alumno']; ?></td>
                <td class="align-middle"><?php echo $fila['Escuela']; ?></td>
                <td class="align-middle"><?php echo $fila['Grado']; ?></td>
                <td class="align-middle"><?php echo $fila['Grupo']; ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody> 
        </table> 
    </div>
  </div>
</div>
  
<script src="../js/houdini.js"></script>

<script>
    $(document).ready(function () {
        $(document.body).on("click", "td[data-href]", function () {
            window.location.href = this.dataset.href + "?idAlumno=" + this.dataset.id;
        });
    });
</script>
</body>
</html>