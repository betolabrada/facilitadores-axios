<?php 
  include 'navbar_admin.php'; 
  require_once '../models/Escuela.php';
  require_once '../models/Grupo.php';

  function nombre_escuela($escuelas) {
    foreach ($escuelas as $s) {
      if ($s['idEscuela'] == $_GET['idEscuela']) {
        return $s['nombre'];
      }
    }
  }

  $escuela_model = new Escuela;
  $grupo_model = new Grupo;

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
    if (!$_GET['idEscuela'] || !$_GET['turno'] || !$_GET['grado'] || !$_GET['grupo'] ) {
      $_SESSION['message'] = "Error. Por favor completa todos los campos.";
      $badRequest = true;
    } else {

      $selected_escuela = nombre_escuela($escuelas);
      $selected = array(
        'escuela' => $_GET['idEscuela'], 
        'turno' => $_GET['turno'],
        'grado' => $_GET['grado'],
        'grupo' => $_GET['grupo']
      );
      print_r(array_values($selected));
      // version: 7.4.6
      // $grupoId = $grupo_model->getGrupoId(...array_values($selected));
      $grupoId = $grupo_model->getGrupoId(
        $selected['escuela'],
        $selected['turno'],
        $selected['grado'],
        $selected['grupo']
      );
      echo $grupoId;
      $alumnos = $grupo_model->getAlumnos($grupoId);
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
  <form method="GET" action="admin_grupos.php">
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

      <div class="col-sm-3">
        <!-- Filtro turno -->
        <select id="filtroTurno" class="form-control" name="turno">
          <option value="" selected>Turno</option>
          <option value="M" <?=(isset($selected) && $selected['turno'] == "M") ? "selected" : "" ?>>Matutino</option>
          <option value="V" <?=(isset($selected) && $selected['turno'] == "V") ? "selected" : "" ?>>Vespertino</option>
        </select>
      </div><!--col-->

      <div class="col-sm-3">
        <!-- Filtro grado -->
        <select id="filtroGrado" class="form-control" name="grado">
          <option value="" selected>Grado</option>
            <?php for ($gr=1; $gr <= 3; $gr++): ?>
              <?php if (isset($selected) && $selected['grado'] == $gr): ?>
              <option value="<?=$gr?>" selected><?=$gr?></option>
              <?php else: ?>
              <option value="<?=$gr?>"><?=$gr?></option>
              <?php endif; ?>
            <?php endfor; ?>
        </select>
      </div><!--col-->

    </div><!--row-->
    
    <div class="row mt-3">

      <div class="col-sm-3">
        <!-- Filtro grupo -->
        <select id="filtroGrupo" class="form-control" name="grupo">
          <option value="" selected>Grupo</option>
          <?php foreach (str_split('ABCDEF') as $gr): ?>
            <?php if (isset($selected) && $selected['grupo'] == $gr): ?>
            <option value="<?=$gr?>" selected><?=$gr?></option>
            <?php else: ?>
            <option value="<?=$gr?>"><?=$gr?></option>
            <?php endif; ?>
          <?php endforeach; ?>
        </select>
      </div><!--col-->

    </div><!--row-->

    <div class="row mt-3">
      <div class="col-sm-12 d-flex justify-content-center">
        <button name="search" value="1" type="submit" class="btn btn-success flex-grow-1">Buscar Alumnos</button>
      </div>
    </div><!--row-->

  </form>

  <?php if ($resultAlumnosSuccess):?>
    <div class="row justify-content-center mt-3">
      <table class="table table-sm">
        <thead>
          <tr>
            <th scope="col">No. LISTA</th>
            <th scope="col">NOMBRE(s)</th>
            <th scope="col">APELLIDOS</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($alumnos as $fila):?>
          <tr>
            <td scope="row"><?=$fila['noLista']?></td>
            <td><?=$fila['nombre']?></td>
            <td><?=$fila['apellido']?></td>
          </tr>
          <?php endforeach;?>
        </tbody>
      </table>
    </div><!--row-->
  <?php elseif ($busqueda && !$resultAlumnosSuccess): ?>
    <div class="pt-3 text-center">No hay alumnos para mostrar: Grupo no existe o está vacío</div>
    
  <?php endif;?>

</div><!--container-->
</body>
</html>