<?php 
include 'navbar_admin.php'; 
require_once '../models/Alumno.php';
require_once '../models/Escuela.php';
require_once '../models/Asesor.php';

$idAlumno = (int)$_GET['idAlumno'];
$alumno_model = new Alumno();
$escuela_model = new Escuela();
$asesor_model = new Asesor();

$alumno = $alumno_model->getAlumnoById($idAlumno);
$escuelas = $escuela_model->getEscuelas();
$asesores = $asesor_model->getAsesores();
  
$oldNombres = $alumno['Nombres'];
$oldApellidos = $alumno['Apellidos'];
$oldNoLista = $alumno['NoLista'];
$oldEscuela = $alumno['Escuela'];
$oldGrado = $alumno['Grado'];
$oldGrupo = $alumno['Grupo'];
$oldTurno = $alumno['Turno'];
$oldAsesor = $alumno['NAsesor'];

if (isset($_POST['subir'])) {
  print_r($_POST);
  $nombres = $_POST['nombres'];
  $apellidos = $_POST['apellidos'];
  $nolista = $_POST['nolista'];
  $escuela = $_POST['escuela'];
  $grado = $_POST['grado'];
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
    $query = "UPDATE Alumno SET noLista= $nolista, nombre='" . $nombres . "', apellido='" . $apellidos . "', idGrupo= $idGrupo WHERE idAlumno = $idAlumno";
    if ($conn->query($query) === TRUE) {
      $message = "Cambios guardados con éxito";
      echo "<script type='text/javascript'>alert('$message');</script>";
    } else {
        $message = "Error: " . $query . "<br>" . $conn->error;
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
  }
}
if (isset($_POST['borrar'])) {
    include '../config/Conn.php';
    $query = "DELETE FROM Alumno WHERE idAlumno = $idAlumno";
    if ($conn->query($query) === TRUE) {
        $message = "Alumno borrado con éxito";
        echo "<script type='text/javascript'>alert('$message');</script>";
        echo "<script type='text/javascript'> document.location = 'admin_alumnos.php'; </script>";
    } else {
      $message = "Error: " . $query . "<br>" . $conn->error;
      echo "<script type='text/javascript'>alert('$message');</script>";
    }
}
?>

<div class="container">
  <h4 class="display-4 text-center">Datos del alumno:</h4>
  <br>
  <h4 class="text-center"><?php echo $alumno['Alumno']; ?></h4>
  <div class="row justify-content-center">
    <div class="col-md-10">
      <form method="post" action="" id="insertForm" onsubmit="return validateForm()">
        <div class="row my-4 justify-content-center">
          <div class="col-sm-8">

            <label for="input-nombre">Nombre(s)</label>
            <input type="input-nombre" class="form-control" name="nombres" placeholder="<?php echo $alumno['Nombres']; ?>" readonly>

            <label for="input-apellidos">Apellido(s)</label>
            <input type="input-apellidos" class="form-control" name="apellidos" placeholder="<?php echo $alumno['Apellidos']; ?>" readonly>

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

            <label for="input-grado">Grado</label>
            <select id="grado" class="form-control" name="grado">
              <option value="" selected>Grado</option>
              <?php for ($gr=1; $gr <= 3; $gr++): ?>
                <?php if ($gr == $alumno['Grado']): ?>
                  <option value="<?=$gr?>" selected><?=$gr?></option>
                <?php else: ?>
                  <option value="<?=$gr?>"><?=$gr?></option>
                <?php endif; ?>
              <?php endfor; ?>
            </select>

            <label for="input-grupo">Grupo</label>
            <select id="grupo" class="form-control" name="grupo">
              <option value="" selected>Grado</option>
              <?php foreach (str_split('ABCDEF') as $gr): ?>
                <?php if ($gr == $alumno['Grupo']): ?>
                  <option value="<?=$gr?>" selected><?=$gr?></option>
                <?php else: ?>
                  <option value="<?=$gr?>"><?=$gr?></option>
                <?php endif; ?>
              <?php endforeach; ?>
            </select>

            <label for="input-turno">Turno</label>
            <select id="turno" class="form-control" name="turno">
              <option value="" selected>Turno</option>
              <option value="M" <?=($alumno['Turno'] == "Matutino") ? "selected" : "" ?>>Matutino</option>
              <option value="V" <?=($alumno['Turno'] == "Vespertino") ? "selected" : "" ?>>Vespertino</option>
            </select>

            <label for="input-asesor">Facilitador</label>
            <select id="asesor" class="form-control" name="asesor">
            <option value="" selected>Facilitador</option>
              <?php foreach ($asesores as $fila): ?>
              <?php if ($alumno['idAsesor'] == $fila['idAsesor']): ?>
              <option value="<?=$fila['idAsesor'] ?>" selected><?=$fila['nombre'] ?></option>
              <?php else:?>
              <option value="<?=$fila['idAsesor'] ?>"><?=$fila['nombre'] ?></option>
              <?php endif;?>
              <?php endforeach; ?>
            </select>

          </div><!--col-->
        </div><!--row-->
      </form>
      <div class="row my-4 justify-content-center">
        <div class="col-sm-3">
          <button class="btn btn-success btn-lg btn-primary btn-block text-uppercase" name="subir" form="insertForm">Aceptar cambios</button>
        </div>
        <div class="col-sm-3">
          <button class="btn btn-danger btn-lg btn-primary btn-block text-uppercase" name="borrar" form="insertForm">Borrar alumno</button>
        </div>
        <div class="col-sm-3">
          <button class="btn btn-danger btn-lg btn-primary btn-block text-uppercase" onclick="window.location.href='admin_alumnos.php'">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
</body>
</html>