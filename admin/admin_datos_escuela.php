<?php include 'navbar_admin.php'; 
$idEscuela = (int)$_GET['idEscuela'];

require_once '../models/Escuela.php';
require_once '../models/Sede.php';

$turnos_disponibles = array(
  'M' => 'Matutino',
  'V' => 'Vespertino',
  'A' => 'Ambos'
);


$escuela_model = new Escuela;
$sede_model = new Sede;

$escuela = $escuela_model->getEscuela($idEscuela);
print_r($escuela);
$sedes = $sede_model->getSedes();

if (isset($_POST['subir'])) {
  $oldNombre = $escuela['nombre'];
  $oldNumero = $escuela['numero'];
  $oldTurno = $escuela['turno'];
  $oldLocalidad = $escuela['idLocalidad'];
  print_r($_POST);
  $nombre = $_POST['nombre'];
  $numero = $_POST['numero'];
  $turno = $_POST['turno'];
  $localidad = $_POST['localidad'];
  $noChanges = 0;

  if($nombre === $oldNombre || $nombre === "") {
    $nombre = $oldNombre;
    $noChanges++;
  }

  if($numero === $oldNumero || $numero === "") {
    $numero = $oldNumero;
    $noChanges++;
  }
  
  if($turno === $oldTurno || $turno === "") {
    $turno = $oldTurno;
    $noChanges++;
  }

  if($localidad === $oldLocalidad || $localidad === "") {
    $localidad = $oldLocalidad;
    $noChanges++;
  }

  if($noChanges == 4) {
    $message = "No se realizaron cambios a los datos de la escuela";
    echo "<script type='text/javascript'>alert('$message');</script>";
  } else {
    // Send data to update
    $modified_data = array(
      'idEscuela' => $idEscuela,
      'nombre' => $nombre,
      'numero' => $numero,
      'turno' => $turno,
      'idLocalidad' => $localidad    
    );

    $updated = $escuela_model->updateEscuela(...array_values($modified_data));
    if ($updated) {
        $message = "Cambios guardados con éxito";
        echo "<script type='text/javascript'>alert('$message');</script>";
        echo "<script type='text/javascript'>document.location = 'admin_sedes.php'; </script>";

    } else {
      $message = "Error: " . $query . "<br>" . $conn->error;
      echo "<script type='text/javascript'>alert('$message');</script>";
    }
  }
}
?>

<div class="container">
  <h4 class="display-4 text-center">Datos de la escuela:</h4>
  <br>
  <h4 class="text-center"><?php echo $escuela['nombre']; ?></h4>
    <div class="row justify-content-center">
      <div class="col-md-10">
        <form method="post" action="" id="insertForm" onsubmit="return validateForm()">
        <div class="row my-4">
          <div class="col-sm-2"></div>
          <div class="col-sm-8">
            <label for="input-nombre">Nombre</label>
            <input type="input-nombre" class="form-control" name="nombre" placeholder="<?php echo $escuela['nombre']; ?>">

            <label for="input-numero">Número</label>
            <input type="input-numero" class="form-control" name="numero" placeholder="<?php echo $escuela['numero']; ?>">

            <label for="input-turno">Turno</label>
            <select id="input-turno" class="form-control" name="turno">
              <option value="" selected>Turno</option>
              <?php foreach ($turnos_disponibles as $tt => $td): ?>
                <?php if ($tt == $escuela['turno']): ?>
                  <option value="<?=$tt?>" selected><?=$td?></option>
                <?php else: ?>
                  <option value="<?=$tt?>"><?=$td?></option>
                <?php endif; ?>
              <?php endforeach; ?>
            </select>

            <label for="input-localidad">Localidad</label>
            <select id="localidad" class="form-control" name="localidad">
              <option value="" selected>Sede</option>
              <?php foreach ($sedes as $fila): ?>
                <?php if ($fila['idLocalidad'] == $escuela['idLocalidad']): ?>
                  <option value="<?=$fila['idLocalidad'] ?>" selected><?=$fila['nombre'] ?></option>
                <?php else: ?>
                  <option value="<?=$fila['idLocalidad'] ?>"><?=$fila['nombre'] ?></option>
                <?php endif; ?>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        </form>
        <div class="row my-4 justify-content-center">
          <div class="col-sm-3">
            <button class="btn btn-success btn-lg btn-primary btn-block text-uppercase" name="subir" form="insertForm">Aceptar cambios</button>
          </div>
          <div class="col-sm-3">
            <button class="btn btn-danger btn-lg btn-primary btn-block text-uppercase" onclick="window.location.href='admin_sedes.php'">Cancelar</button>
          </div>
        </div>
    </div>
  </div>
</body>
</html>