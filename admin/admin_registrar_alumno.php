<?php 

  include 'navbar_admin.php';

  $escuela_model = new Escuela;
  $asesor_model = new Asesor;
  $grupo_model = new Grupo;
  $alumno_model = new Alumno;

  $escuelas = $escuela_model->getEscuelas();
  $asesores = $asesor_model->getAsesores();

  if (isset($_POST['subir'])) {
    print_r($_POST);
    extract($_POST);
    // Validar que todo se haya llenado
    if (empty($noLista) || empty($idEscuela) || empty($turno) || empty($grupo)) {
      $_SESSION['message'] = "Por favor completa todos los campos.";
    } else {
      // Busqueda de grupo por idEscuela, turno (M|V), grupo (numero y letra)
      $params = array(
        'idEscuela' => (int) $idEscuela, 
        'turno' => $turno,
        'grupo' => strtoupper($grupo)
      );
      $idGrupo = $grupo_model->getGrupoId(
        $params['idEscuela'],
        $params['turno'],
        $params['grupo']
      );
      if (!$idGrupo) {
        $_SESSION['message'] = "No se encontró el grupo que buscaste, reintentar con diferentes datos";
      }
    }

    if ($idGrupo) {
      // Insertar nuevo alumno en grupo
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


    
    // if(!$group_exists) {
    //     $message = "Los datos ingresados no son válidos. Por favor ingresa una combinación permitida.";
    //     echo "<script type='text/javascript'>alert('$message');</script>";
    // } else {
    //     // Insertar nuevo alumno
    //     $idGrupo = $group_exists['idGrupo'];
    //     $inserted = $alumno_model->insertarAlumno($noLista, $nombres, $apellidos, $idGrupo);

    //     if ($inserted) {
    //         $message = "Cambios guardados con éxito";
    //         echo "<script type='text/javascript'>alert('$message');</script>";
    //         echo "<script type='text/javascript'> document.location = 'admin_alumnos.php'; </script>";
    //     } else {
    //         $message = "Error: " . $query . "<br>";
    //         echo "<script type='text/javascript'>alert('$message');</script>";
    //     }
    // }
  }
?>

  <div class="container">
    <?php if (isset($_SESSION['message'])):?>
    <div class="alert alert-danger" role="alert">
      <?=$_SESSION['message'] ?>
    </div>
    <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
    <h4 class="display-4 text-center">Datos del nuevo alumno:</h4>
    <div class="row justify-content-center">
      <div class="col-md-10">
        <form method="post" action="" id="insertForm" onsubmit="return validateForm()">
        <div class="row my-4">
          <div class="col-sm-2"></div>
          <div class="col-sm-8">

            <label for="input-nlista">Número de Lista</label>
            <input type="input-nlista" class="form-control" name="noLista" placeholder="Número de Lista">

            <label for="input-nombre">Nombre(s)</label>
            <input type="input-nombre" class="form-control" name="nombres" placeholder="Nombres">

            <label for="input-apellidos">Apellido(s)</label>
            <input type="input-apellidos" class="form-control" name="apellidos" placeholder="Apellidos">

            <label for="input-escuela">Escuela</label>
            <select id="escuela" class="form-control" name="idEscuela">
              <option value="" selected>Escuela</option>
              <?php foreach ($escuelas as $fila): ?>
              <option value="<?=$fila['idEscuela'] ?>"><?=$fila['nombre'] ?></option>
              <?php endforeach; ?>
            </select>

            <label for="input-turno">Turno</label>
            <select id="turno" class="form-control" name="turno">
              <option value="" selected>Turno</option>
              <option value="M">Matutino</option>
              <option value="V">Vespertino</option>
            </select>

            <label for="input-grupo">Grupo</label>
            <input type="text" class="form-control" id="grupo" aria-describedby="grupoHelp" 
            placeholder="Grupo" name="grupo">
            <small id="grupoHelp" class="form-text text-muted">Escribe un numero seguido de una letra</small>

            

          </div>
        </div>
        </form>
        <div class="row my-4 justify-content-center">
          <div class="col-sm-3">
            <button class="btn btn-success btn-lg btn-block text-uppercase" name="subir" 
              form="insertForm">Crear alumno</button>
          </div>
          <div class="col-sm-3">
            <button class="btn btn-danger btn-lg btn-block text-uppercase" 
              onclick="window.location.href='admin_alumnos.php'">Cancelar</button>
          </div>
        </div>
    </div>
  </div>
</body>
</html>