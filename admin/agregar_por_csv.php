
<?php include 'navbar_admin.php'; ?>
<?php

require_once '../models/Grupo.php';
require_once '../models/Alumno.php';
require_once '../models/Asesor.php';

$grupo_model = new Grupo;
$alumno_model = new Alumno;
$asesor_model = new Asesor;


if (!isset($_GET['id'])) {
  $grupoId = 1;
} else {
  $grupoId = $_GET['id'];
}

$asesorDeGrupo = $asesor_model->getAsesorDeGrupo($grupoId);


// Alumnos de grupo
$alumnos = $grupo_model->getAlumnos($grupoId);

if (isset($_POST['importar'])) {
  // Grupo debe de estar vacio para importar csv
  if (count($alumnos) > 0) {
    $_SESSION['message'] = "Primero, exporta y limpia la lista";
  } else {
    // Valida que haya un archivo
    if ($_FILES['archivo']['size'] > 0) {
      // Get tmp name of file
      $filename = $_FILES['archivo']['tmp_name'];
      // Open file
      $file = fopen($filename, "r");
      // ignore header
      $header = fgetcsv($file, 10000, ","); 
      while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
        // Define params to insert
        $params = array (
          'noLista' => $column[0],
          'nombre' => utf8_encode($column[1]),
          'apellido' => utf8_encode($column[2]),
          'idGrupo' => $grupoId
        );
        // Insert to DB
        $inserted = $alumno_model->insertarAlumno(...$params);
        
        // Check if error
        if (!$inserted) {
          echo "ERROR EN QUERY";
          break;
        }
      }
      fclose($file);
      echo "<meta http-equiv='refresh' content='0'>";
    } else {
      $_SESSION['message'] = "Por favor importa un archivo CSV.";
    }
  }
}

if (isset($_POST['delete'])) {
  
  $deleted = $alumno_model->deleteLista($grupoId);

  if ($deleted) {
    echo "<meta http-equiv='refresh' content='0'>";
  } else {
    echo "<script type='text/javascript'>alert('ERROR');</script>";
  }

}
?>
<div class="container">
  <?php if (isset($_SESSION['message'])):?>
  <div class="alert alert-warning">
  <?php
    echo $_SESSION['message'];
    unset($_SESSION['message']);
  ?>
  </div><!--alert-->
  <?php endif; ?>
  <form id="#formCSVImport" method="POST" name="subirCSV" enctype="multipart/form-data">
    <div class="row mt-3">
      <div class="col-sm-6">
        <label for="inputArchivo" class="col-form-label">Subir archivo CSV</label>
        <input type="file" name="archivo" id="inputArchivo" accept=".csv">
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-sm-3">
        <button type="submit" name="importar" class="btn btn-success">Importar Alumnos</button>
      </div>
      <!-- Button trigger modal -->
      <div class="col-sm-3">
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
          Limpiar lista
        </button>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Borrar lista</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              ¿Seguro(a) que quieres borrar los alumnos de esta lista?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="submit" name="delete" class="btn btn-danger">Borrar</button>
            </div><!--modal-footer-->
          </div><!--modal-content-->
        </div><!--modal-dialog-->
      </div><!--modal-fade-->
    </div><!--row-->
  </form> 
  <form method="post" action="exportar_csv.php?id=<?=$grupoId?>">
  <div class="row mt-3">
    <div class="col-sm-3">
      <button type="submit" name="exportar_grupo" class="btn btn-secondary">Exportar grupo</button>
    </div>
  </div>
  </form>     
<?php
  echo "<p>Grupo: <strong>" . $asesorDeGrupo['grupo'] . "</strong></p>";
  echo "<p>Escuela: <strong> " . $asesorDeGrupo['nombreEscuela'] . "</strong></p>";
  echo "<p>Turno: <strong> " . $asesorDeGrupo['tipo'] . "</strong></p>";
  echo "<p>Descripcion: <strong> " . $asesorDeGrupo['numero'] . " ". $asesorDeGrupo['sede'] . " " . $asesorDeGrupo['descripcion']  . "</strong></p>";
?>

<?php if (count($alumnos) == 0):?>
  <h3>No hay alumnos en este grupo</h3>
<?php else:?>
  <table id="alumnos-subidos">
    <thead>
      <tr>
        <th>No. LISTA</th>
        <th>NOMBRE(s)</th>
        <th>APELLIDOS</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($alumnos as $fila):?>
      <tr>
        <td><?=$fila['noLista']?></td>
        <td><?=$fila['nombre']?></td>
        <td><?=$fila['apellido']?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php endif;?>
</div>
</body>
</html>

