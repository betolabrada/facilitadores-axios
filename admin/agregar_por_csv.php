
<?php include 'navbar_admin.php'; ?>
<?php

$grupo_model = new Grupo;
$alumno_model = new Alumno;
$asesor_model = new Asesor;


if (!isset($_GET['idGrupo'])) {
  $idGrupo = 1;
} else {
  $idGrupo = $_GET['idGrupo'];
}

$asesorDeGrupo = $asesor_model->getAsesorDeGrupo($idGrupo);


// Alumnos de grupo
$alumnos = $grupo_model->getAlumnos($idGrupo);

// toExport
$_SESSION['toExport'] = $alumnos;

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
          'noLista' => (int) $column[0],
          'idAlumno' => (int) $column[1],
          'nombre' => utf8_encode($column[2]),
          'apellido' => utf8_encode($column[3]),
          'idGrupo' => (int) $idGrupo
        );
        extract($params);
        // Insert to DB
        $inserted = $alumno_model->insertarAlumno($noLista, $nombre, $apellido, $idGrupo, $idAlumno);
        
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
  
  $deleted = $alumno_model->deleteLista($idGrupo);

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
    <div class="row my-3">
      <div class="col-sm-3">
        <button type="submit" name="importar" class="btn btn-success btn-block">Importar Alumnos</button>
      </div>

      <div class="col-sm-3">
        <button 
          type="submit" 
          name="exportar" 
          value="Exportar" 
          class="btn btn-dark btn-block" 
          formaction="exportar_csv.php"
          formmethod="get"
        >Exportar grupo
        </button>
      </div>

      <!-- Button trigger modal -->
      <div class="col-sm-3">
        <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#exampleModal">
          Limpiar lista
        </button>
      </div>

      <div class="col-sm-3">
        <button  
          type="button"
          class="btn btn-secondary btn-block"
          onclick="window.location.href='admin_grupos.php'" 
        >Regresar
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
              Los datos se borrarán para SIEMPRE y será IMPOSIBLE recuperarlos. Asegúrate de exportar la lista antes de hacer este paso
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" data-dismiss="modal">Ir a exportar</button>
              <button type="submit" name="delete" class="btn btn-danger">Ya estoy seguro, borrar</button>
            </div><!--modal-footer-->
          </div><!--modal-content-->
        </div><!--modal-dialog-->
      </div><!--modal-fade-->
    </div><!--row-->
  </form> 
<?php
  echo "<p>Grupo: <strong>" . $asesorDeGrupo['grupo'] . "</strong><br>";
  echo "Escuela: <strong> " . $asesorDeGrupo['nombreEscuela'] . "</strong><br>";
  echo "Turno: <strong> " . $asesorDeGrupo['tipo'] . "</strong><br>";
  echo "Descripcion: <strong> " . $asesorDeGrupo['numero'] . " ". $asesorDeGrupo['sede'] . " " . $asesorDeGrupo['descripcion']  . "</strong></p>";
?>

<?php if (count($alumnos) == 0):?>
  <h3>No hay alumnos en este grupo</h3>
<?php else:?>
  <table id="alumnos-subidos">
    <thead>
      <tr>
        <th>No. LISTA</th>
        <th>No. ALUMNO</th>
        <th>NOMBRE(s)</th>
        <th>APELLIDOS</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($alumnos as $fila):?>
      <tr>
        <td><?=$fila['noLista']?></td>
        <td><?=$fila['idAlumno']?></td>
        <td><?=$fila['nombre']?></td>
        <td><?=$fila['apellido']?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php endif;?>
</div>

<?php include '../bootstrap_js.php' ?>

</body>
</html>

