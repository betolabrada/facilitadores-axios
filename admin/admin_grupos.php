<?php 
  include 'navbar_admin.php'; 

  $escuela_model = new Escuela();
  $grupo_model = new Grupo();

  // Escuelas
  $escuelas = $escuela_model->getEscuelas();

  // Datos de busqueda
  $busqueda = false;
  $datos = null;

  // Alumnos
  $resultAlumnosSuccess = false;

  // Busqueda
  if (isset($_GET['search'])) {
    $busqueda = true;
    if (!$_GET['idEscuela'] || !$_GET['turno'] || !$_GET['grupo'] ) {
      $_SESSION['message'] = "Por favor completa todos los campos.";
      $badRequest = true;
    } else {

      $selected_escuela = $escuela_model->getEscuela($_GET['idEscuela'])['nombre'];
      $selected = array(
        'escuela' => (int) $_GET['idEscuela'], 
        'turno' => $_GET['turno'],
        'grupo' => strtoupper($_GET['grupo'])
      );
      $idGrupo = $grupo_model->getGrupoId(
        $selected['escuela'],
        $selected['turno'],
        $selected['grupo']
      );
      $alumnos = $grupo_model->getAlumnos($idGrupo);
      if (count($alumnos) > 0) {
        $resultAlumnosSuccess = true;
      }
      echo $resultAlumnosSuccess;
    }
  }

?>

<div class="container my-3">
  <?php if (isset($_SESSION['message'])):?>
    <div class="alert alert-danger">
      <?php
        echo $_SESSION['message'];
        unset($_SESSION['message']);
      ?>
    </div><!--alert-->
  <?php endif; ?>
  <div class="row">
    <div class="col-sm-4">
      <h4>Búsqueda</h4>
    </div>
  </div><!--row-->
  <form>
    <div class="row mt-3">
      <div class="col-sm-6">
        <!-- First search filter: filtro escuela -->
        <select id="filtroEscuela" class="form-control" name="idEscuela">
          <option value="0">Escuela</option>
          <?php foreach ($escuelas as $fila): ?>
          <?php if (isset($selected) && $selected['escuela'] == $fila['idEscuela']): ?>
          <option value="<?=$fila['idEscuela'] ?>" selected><?=$fila['nombre'] ?></option>
          <?php else:?>
          <option value="<?=$fila['idEscuela'] ?>"><?=$fila['nombre'] ?></option>
          <?php endif;?>
          <?php endforeach; ?>
        </select>
      </div><!--col-->

      <div class="col-sm-2">
        <!-- Filtro turno -->
        <select id="filtroTurno" class="form-control" name="turno">
          <option value="" selected>Turno</option>
          <option value="M" <?=(isset($selected) && $selected['turno'] == "M") ? "selected" : "" ?>>
            Matutino</option>
          <option value="V" <?=(isset($selected) && $selected['turno'] == "V") ? "selected" : "" ?>>
            Vespertino</option>
        </select>
      </div><!--col-->    

      <div class="col-sm-2">
        <!-- Filtro grupo -->
        <input type="text" class="form-control" id="grupo" aria-describedby="grupoHelp" placeholder="Grupo"
          name="grupo">
        <small id="grupoHelp" class="form-text text-muted">Escribe un numero seguido de una letra</small>
      </div><!--col-->
    </div><!--row-->

    <div class="row mt-3">
      <div class="col-sm-12 d-flex justify-content-center">
        <button name="search" value="1" type="submit" class="btn btn-success flex-grow-1">Buscar Alumnos</button>
      </div>
    </div><!--row-->

  </form>
  <div class="row mt-4">
    <div class="col-sm-3">
      <button class="btn btn-success btn-lg btn-block text-uppercase" form="crearForm">
        Nuevo Grupo</button>
    </div>

    <?php if(isset($idGrupo)) :?>
      <div class="col-sm-3">
        <button class="btn btn-warning btn-lg btn-block text-uppercase" form="editForm"
          onclick="window.location.href='confirmar_editar_grupo.php?idGrupo=<?=$idGrupo?>'">
          Editar Grupo
        </button>
      </div>
      <div class="col-sm-3">
        <button class="btn btn-info btn-lg btn-block text-uppercase" form="editForm"
          onclick="window.location.href='agregar_por_csv.php?idGrupo=<?=$idGrupo?>'">
          Manejo de Archivo
        </button>
      </div>
    <?php endif; ?>
  </div>

  <?php if ($resultAlumnosSuccess):?>
    <div class="row justify-content-center mt-3">
      <div class="col-10">
        <div class="table-responsive">
          <table class="table-pagination table table-sm">
            <thead>
              <tr>
                <th scope="col">No. LISTA</th>
                <th scope="col">No. Alumno</th>
                <th scope="col">NOMBRE(s)</th>
                <th scope="col">APELLIDOS</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($alumnos as $fila):?>
              <tr>
                <td><?=$fila['noLista']?></td>
                <td data-href="alumno_historial.php" data-id="<?=$fila['idAlumno']?>">
                  <?=$fila['idAlumno']?>
                </td>
                <td><?=$fila['nombre']?></td>
                <td><?=$fila['apellido']?></td>
              </tr>
              <?php endforeach;?>
            </tbody>
          </table>
        </div><!--table responsive-->
      </div><!--col-->
    </div><!--row-->
  <?php elseif ($busqueda && !$resultAlumnosSuccess): ?>
    <div class="pt-3 text-center">No hay alumnos para mostrar: Grupo no existe o está vacío</div>
    
  <?php endif;?>

</div><!--container-->

<?php include '../bootstrap_js.php' ?>
<script src='../js/paginacion/tablePagination.js'></script>
<script src='../js/paginacion/index.js'></script>
<script>
$(document).ready(function () {
  $(document.body).on('click', 'td[data-href]', function () {
    window.location.href = this.dataset.href + '?idAlumno='+ this.dataset.id;
  })
})
</script>

</body>
</html>