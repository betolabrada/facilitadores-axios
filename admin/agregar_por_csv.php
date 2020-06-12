
<?php include 'navbar_admin.php'; ?>
<?php

include '../config/Conn.php';

if (!isset($_GET['id'])) {
  $grupoId = 1;
} else {
  $grupoId = $_GET['id'];
}


$alumnos = getAlumnos($grupoId);

function getAlumnos($grupoId) {

  $conn = $GLOBALS['conn'];

  $sql = "SELECT * FROM Alumno WHERE idGrupo = " . $grupoId . " ORDER BY idAlumno";
  $result = $conn->query($sql) or die($conn->error);

  return $result;

}

function importarAlumnos($alumnos) {
  $conn = $GLOBALS['conn'];
  $grupoId = $GLOBALS['grupoId'];

  if ($alumnos->num_rows > 0) {
    $_SESSION['message'] = "Primero, exporta y limpia la lista";
    return;
  }

  if ($_FILES['archivo']['size'] > 0) {
    // Get tmp name of file
    $filename = $_FILES['archivo']['tmp_name'];
    $file = fopen($filename, "r");
    $header = fgetcsv($file, 10000, ","); // ignore header
    while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
      $sql = "INSERT INTO Alumno (noLista, nombre, apellido, idGrupo) 
      VALUES (". $column[0] . ",'" . utf8_encode($column[1]) . "','" . 
        utf8_encode($column[2]) . "'," . $grupoId . ")";

      $result = $conn->query($sql);

      if (!$result) {
        echo "ERROR EN QUERY: " . $sql;
        echo $conn->error;
        break;
      }
    }
    fclose($file);
    header("Refresh:0");  
  } else {
    $_SESSION['message'] = "Por favor importa un archivo CSV.";
  }
}
if (isset($_POST['importar'])) {
  importarAlumnos($alumnos);

}

if (isset($_POST['delete'])) {
  $sql = "DELETE FROM Alumno WHERE idGrupo = $grupoId";

  $conn->query($sql) or die($conn->error);

  header("Refresh:0");
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
// query 1 get asesor de grupo
$sql = "SELECT 
        grup.grupo, a.nombre, e.nombre as nombreEscuela, t.tipo, t.descripcion, e.numero, l.nombre as sede
    FROM Grupo grup 
        JOIN Grado grad on grad.idGrado = grup.idGrado 
        JOIN Turno t on t.idTurno = grad.idTurno 
        JOIN Asesor a on a.idAsesor = t.idAsesor 
        JOIN Escuela e on e.idEscuela = t.idEscuela
        JOIN Localidad l on l.idLocalidad = e.idLocalidad
    WHERE idGrupo =" . $grupoId;

$result = $conn->query($sql);
if ($result) {
    $row = $result->fetch_assoc();
    echo "<p>Grupo: <strong>" . $row['grupo'] . "</strong></p>";
    echo "<p>Escuela: <strong> " . $row['nombreEscuela'] . "</strong></p>";
    echo "<p>Turno: <strong> " . $row['tipo'] . "</strong></p>";
    echo "<p>Descripcion: <strong> " . $row['numero'] . " ". $row['sede'] . " " . $row['descripcion']  . "</strong></p>";

}
else {
    echo $conn->error;
    echo $sql;
}

?>

<?php if ($alumnos->num_rows == 0):?>
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
    <?php while ($fila = $alumnos->fetch_assoc()):?>
    <tr>
      <td><?=$fila['noLista']?></td>
      <td><?=$fila['nombre']?></td>
      <td><?=$fila['apellido']?></td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>
<?php endif;?>
</div>
<?php $conn->close(); ?>
</body>
</html>

