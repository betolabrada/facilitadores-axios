<?php 
include 'navbar_admin.php'; 

$idAlumno = (int)$_GET['idAlumno'];
$alumno_model = new Alumno();
$escuela_model = new Escuela();
$asesor_model = new Asesor();

$alumno = $alumno_model->getAlumnoById($idAlumno);
if (!$alumno) {
  $message = "El alumno que buscas no se ha encontrado";
  echo "<script type='text/javascript'>alert('$message');</script>";
  echo "<script type='text/javascript'> document.location = 'admin_alumnos.php'; </script>";
}
$escuelas = $escuela_model->getEscuelas();
$asesores = $asesor_model->getAsesores();
  
$oldNombres = $alumno['Nombres'];
$oldApellidos = $alumno['Apellidos'];
$oldNoLista = $alumno['NoLista'];
$oldEscuela = $alumno['Escuela'];
$oldGrupo = $alumno['Grupo'];
$oldTurno = $alumno['Turno'];
$oldAsesor = $alumno['NAsesor'];


if (isset($_POST['subir'])) {
  print_r($_POST);
  $nombres = $_POST['nombres'];
  $apellidos = $_POST['apellidos'];
  $nolista = $_POST['nolista'];
  $escuela = $_POST['escuela'];
  $grupo = $_POST['grupo'];
  $turno = $_POST['turno'];
  $asesor = $_POST['asesor'];
  $noChanges = 0;

  if($nombres === $oldNombres || $nombres === "") {
    $nombres = $oldNombres;
    $noChanges++;
  }

  if($apellidos === $oldApellidos || $apellidos === "") {
    $apellidos = $oldApellidos;
    $noChanges++;
  }
  
  if($nolista === $oldNoLista || $nolista === "") {
    $nolista = $oldNoLista;
    $noChanges++;
  }

  if($escuela === $oldEscuela || $escuela === "") {
    $escuela = $oldEscuela;
    $noChanges++;
  }

  if($grado === $oldGrado || $grado === "") {
    $grado = $oldGrado;
    $noChanges++;
  }

  if($grupo === $oldGrupo || $grupo === "") {
    $grupo = $oldGrupo;
    $noChanges++;
  }

  if($turno === $oldTurno || $turno === "") {
    $turno = $oldTurno;
    $noChanges++;
  }

  if($asesor === $oldAsesor || $asesor === "") {
    $asesor = $oldAsesor;
    $noChanges++;
  }

  if($noChanges == 8) {
    $message = "No se realizaron cambios a los datos del alumno";
    echo "<script type='text/javascript'>alert('$message');</script>";
    echo "<script type='text/javascript'> document.location = 'admin_alumnos.php'; </script>";
  } else {
    
    $idGrupo = $alumno['idGrupo'];
    $updated_alumno = $alumno_model->updateAlumno($idAlumno, $noLista, $nombres, $apellidos, $idGrupo);
    if ($updated_alumno) {
      $message = "Cambios guardados con éxito";
      echo "<script type='text/javascript'>alert('$message');</script>";
    } else {
        $message = "Error: " . $query . "<br>";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
  }
}
if (isset($_POST['borrar'])) {
    
    print_r($_POST);
    if (isset($_POST['tambienAse'])) {
      $deleted = $alumno_model->deleteAlumno($idAlumno, true);
    } else {
      $deleted = $alumno_model->deleteAlumno($idAlumno, false);
    }
    if ($deleted) {
        $message = "Alumno borrado con éxito";
        echo "<script type='text/javascript'>alert('$message');</script>";
        echo "<script type='text/javascript'> document.location = 'admin_alumnos.php'; </script>";
    } else {
      $message = "Error: " . $query . "<br>";
      echo "<script type='text/javascript'>alert('$message');</script>";
    }
}
?>

<div class="container">
  <h4 class="display-4 text-center">Editando Alumno(a):</h4>
  <br>
  <h4 class="text-center"><?php echo $alumno['Alumno']; ?></h4>
  <div class="row justify-content-center">
    <div class="col-md-10">
      <form method="post" action="" id="insertForm" onsubmit="return validateForm()">
        <div class="row my-4 justify-content-center">
          <div class="col-sm-8">

            <label for="input-nombre">Nombre(s)</label>
            <input type="input-nombre" class="form-control" name="nombres" placeholder="<?php echo $alumno['Nombres']; ?>">

            <label for="input-apellidos">Apellido(s)</label>
            <input type="input-apellidos" class="form-control" name="apellidos" placeholder="<?php echo $alumno['Apellidos']; ?>">

            <label for="input-nlista">Número de Lista</label>
            <input type="input-nlista" class="form-control" name="nolista" placeholder="<?php echo $alumno['NoLista']; ?>">

            <label for="input-escuela">Escuela</label>
            <select id="escuela" class="form-control" name="escuela">
              <option value="" selected>Escuela</option>
              <?php foreach ($escuelas as $fila): ?>
                <?php if ($alumno['Escuela'] == $fila['idEscuela']): ?>
                  <option value="<?=$fila['idEscuela'] ?>" selected><?=$fila['nombre'] ?></option>
                <?php else: ?>
                  <option value="<?=$fila['idEscuela'] ?>"><?=$fila['nombre'] ?></option>
                <?php endif; ?>
              <?php endforeach; ?>
            </select>

            <label for="input-turno">Turno</label>
            <select id="turno" class="form-control" name="turno">
              <option value="" selected>Turno</option>
              <option value="M" <?=($alumno['Turno'] == "Matutino") ? "selected" : "" ?>>Matutino</option>
              <option value="V" <?=($alumno['Turno'] == "Vespertino") ? "selected" : "" ?>>Vespertino</option>
            </select>

            <label for="input-grupo">Grupo</label>
            <!-- Filtro grupo -->
            <input type="text" class="form-control" id="grupo" aria-describedby="grupoHelp" 
            placeholder="<?=$oldGrupo?>" name="grupo">
            <small id="grupoHelp" class="form-text text-muted">Escribe un numero seguido de una letra</small>

          </div><!--col-->
        </div><!--row-->
      </form>
      <div class="row my-4 justify-content-center">
        <div class="col-sm-3">
          <button class="btn btn-success btn-lg btn-block text-uppercase" name="subir" form="insertForm">Aceptar cambios</button>
        </div>
        <!-- Button trigger modal -->
        <div class="col-sm-3">
          <button type="button" class="btn btn-danger btn-lg btn-block text-uppercase" data-toggle="modal" data-target="#exampleModal">
            Borrar Alumno
          </button>
        </div>
        <div class="col-sm-3">
          <button class="btn btn-danger btn-lg btn-block text-uppercase" onclick="window.location.href='admin_alumnos.php'">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" 
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Borrar lista</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <p>¿Seguro(a) que quieres borrar a este alumno?
              Los datos se borrarán para SIEMPRE y será IMPOSIBLE recuperarlos.</p>
            </div>
          </div>
          <form id="deleteForm" method="post">
            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input" id="borrarAsesorias" name="tambienAse">
              <label class="form-check-label" for="borrarAsesorias">
                También borrar asesorías de este alumno
              </label>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" name="borrar" form="deleteForm" class="btn btn-danger">
            Estoy seguro(a), borrar</button>
        </div><!--modal-footer-->
      </div><!--modal-content-->
    </div><!--modal-dialog-->
  </div><!--modal-fade-->

  <?php include '../bootstrap_js.php' ?>
</body>
</html>


