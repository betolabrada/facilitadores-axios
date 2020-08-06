<?php include 'navbar_admin.php'; 

require_once '../models/Escuela.php';
require_once '../models/Sede.php';

$turnos_disponibles = array(
  'M' => 'Matutino',
  'V' => 'Vespertino',
  'A' => 'Ambos'
);


$escuela_model = new Escuela;
$sede_model = new Sede;

$sedes = $sede_model->getSedes();


if (isset($_POST['subir'])) {
    if ($escuela_model->insertEscuela($_POST)) {
        echo "datos subidos correctamente";
        header('Location: admin_sedes.php');
    } else {
        echo "ERROR";
    }
}


?>

<div class="container">
  <h4 class="display-4 text-center">Agregar Escuela</h4>
  <br>
    <div class="row justify-content-center">
      <div class="col-md-10">
        <form method="post" id="insertForm">
            <div class="row my-4">
              <div class="col-sm-2"></div>
              <div class="col-sm-8">
                <label for="input-nombre">Nombre</label>
                <input type="input-nombre" class="form-control" name="nombre" required="required">

                <label for="input-numero">Número</label>
                <input type="input-numero" class="form-control" name="numero" required="required">

                <label for="input-turno">Turno</label>
                <select id="input-turno" class="form-control" name="turno">

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
            <button class="btn btn-success btn-lg btn-primary btn-block text-uppercase" name="subir" form="insertForm" type="submit">Aceptar cambios</button>
          </div>
          <div class="col-sm-3">
            <button class="btn btn-danger btn-lg btn-primary btn-block text-uppercase" onclick="window.location.href='admin_sedes.php'">Cancelar</button>
          </div>
        </div>
    </div>
  </div>
</body>
</html>