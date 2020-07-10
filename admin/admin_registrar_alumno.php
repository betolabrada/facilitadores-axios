<?php 

    include 'navbar_admin.php';
    require_once '../models/Escuela.php';
    require_once '../models/Asesor.php';
    require_once '../models/Grupo.php';
    require_once '../models/Alumno.php';

    $escuela_model = new Escuela;
    $asesor_model = new Asesor;
    $grupo_model = new Grupo;
    $alumno_model = new Alumno;

    $escuelas = $escuela_model->getEscuelas();
    $asesores = $asesor_model->getAsesores();

?>

<?php
if (isset($_POST['subir'])) {
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $nolista = $_POST['nolista'];
    $escuela = $_POST['escuela'];
    $grado = $_POST['grado'];
    $grupo = $_POST['grupo'];
    $turno = $_POST['turno'];
    $asesor = $_POST['asesor'];

    $params = array($grupo, $grado, $descTurno, $escuela, $asesor);

    $group_exists = $grupo_model->groupExists(...$params);
    
    if(!$group_exists) {
        $message = "Los datos ingresados no son válidos. Por favor ingresa una combinación permitida.";
        echo "<script type='text/javascript'>alert('$message');</script>";
    } else {
        // Insertar nuevo alumno
        $idGrupo = $group_exists['idGrupo'];
        $inserted = $alumno_model->insertarAlumno($noLista, $nombres, $apellidos, $idGrupo);

        if ($inserted) {
            $message = "Cambios guardados con éxito";
            echo "<script type='text/javascript'>alert('$message');</script>";
            echo "<script type='text/javascript'> document.location = 'admin_alumnos.php'; </script>";
        } else {
            $message = "Error: " . $query . "<br>";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
    }
}
?>

  <div class="container">
  <h4 class="display-4 text-center">Datos del nuevo alumno:</h4>
    <div class="row justify-content-center">
      <div class="col-md-10">
        <form method="post" action="" id="insertForm" onsubmit="return validateForm()">
        <div class="row my-4">
          <div class="col-sm-2"></div>
          <div class="col-sm-8">

            <label for="input-nombre">Nombre(s)</label>
            <input type="input-nombre" class="form-control" name="nombres" placeholder="Nombres">

            <label for="input-apellidos">Apellido(s)</label>
            <input type="input-apellidos" class="form-control" name="apellidos" placeholder="Apellidos">

            <label for="input-nlista">Número de Lista</label>
            <input type="input-nlista" class="form-control" name="nolista" placeholder="Número de Lista">

            <label for="input-escuela">Escuela</label>
            <select id="escuela" class="form-control" name="escuela">
                <option value="" selected>Escuela</option>
                <?php foreach ($escuelas as $fila): ?>
                    <option value="<?=$fila['idEscuela'] ?>"><?=$fila['nombre'] ?></option>
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
                <option value="" selected>Grupo</option>
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
                <option value="M">Matutino</option>
                <option value="V">Vespertino</option>
            </select>

            <label for="input-asesor">Facilitador</label>
            <select id="asesor" class="form-control" name="asesor">
                <option value="" selected>Facilitador</option>
                <?php foreach ($asesores as $fila): ?>
                    <option value="<?=$fila['idEscuela'] ?>"><?=$fila['nombre'] ?></option>
                <?php endforeach; ?>
            </select>

          </div>
        </div>
        </form>
        <div class="row my-4 justify-content-center">
          <div class="col-sm-3">
            <button class="btn btn-success btn-lg btn-primary btn-block text-uppercase" name="subir" form="insertForm">Crear alumno</button>
          </div>
          <div class="col-sm-3">
            <button class="btn btn-danger btn-lg btn-primary btn-block text-uppercase" onclick="window.location.href='admin_alumnos.php'">Cancelar</button>
          </div>
        </div>
    </div>
  </div>
</body>
</html>