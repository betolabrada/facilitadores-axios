<?php
include 'navbar_admin.php';

$alumno_model = new Alumno();
$asesor_model = new Asesor();

$alumnos = $alumno_model->getAlumnos();
$asesores = $asesor_model->getAsesores();

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
  <div class="row mb-3">
    <div class="col-sm-12">
      <h5>FILTROS</h5>
    </div>
  </div>
  <form method="POST" id="filtros">
    <div class="row my-3">
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
      </div><!--col-->
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
      </div><!--col-->
      <div class="col-sm-3">
        <select id="filtroEscuela" class="form-control" name="escuela">
          <option value="" selected>Escuela</option>
          <?php foreach ($escuelas as $fila): ?>
            <?php if (isset($post_escuela) && $post_escuela == $fila['idEscuela']): ?>
              <option value="<?=$fila['idEscuela'] ?>" selected><?=$fila['nombre'] ?></option>
            <?php else: ?>
              <option value="<?=$fila['idEscuela'] ?>"><?=$fila['nombre'] ?></option>
            <?php endif; ?>
          <?php endforeach; ?>
        </select>
      </div><!--col-->
    </div><!--row-->
    
    <div class="row">
      <div class="col-sm-2">
        <button name="filtrar" type="submit" class="btn btn-success">FILTRAR</button>
      </div>
    </div><!--row-->
  </form>


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
            <th scope="col">Grupo</th>
          </thead>
          <tbody id="filter"> 
            <?php foreach ($alumnos as $fila): ?>
              <tr>
                <td data-href="admin_datos_alumno.php" data-id="<?php echo $fila['idAlumno']; ?>" 
                  class="align-middle"><?php echo $fila['Alumno']; ?></td>
                <td class="align-middle"><?php echo $fila['Escuela']; ?></td>
                <td class="align-middle"><?php echo $fila['Grupo']; ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody> 
        </table> 
    </div>
  </div>
</div>
  
<?php include '../bootstrap_js.php'?>
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