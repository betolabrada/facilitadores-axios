<?php 
  include 'init.php';
  include 'asesor_navbar.php';

  $asesor_model = new Asesor;
  $alumno_model = new Alumno;
  $asesoria_model = new Asesoria;

  $asesor = $asesor_model->getAsesorById($_GET['idAsesor']);
  $alumnosDeAsesor = $alumno_model->getAlumnosDeAsesor($asesor['idAsesor']);

  $mail = $asesor['correo'];
  $step = count($_GET);
  $current_page = basename(__FILE__) . '?' . http_build_query($_GET);
  echo $current_page;
  if ($step >= 2) {
    $alumno = $alumno_model->getAlumnoById($_GET['idAlumno']);
  }
  if ($step >= 3) {
    $tiposAsesoria = $asesoria_model->getTipos();
  }
  if ($step >= 4) {
    $motivosAsesoria = $asesoria_model->getMotivos($_GET['idTipoAsesoria']);
  }
    

  // Step 5
  if (isset($_POST['aceptar'])) {
    $fecha = $_POST['fecha'];
    $observaciones = $_POST['observaciones'];

    // Set session vars
    $_SESSION['asesoria']['idAsesor'] = $idAsesor = (int) $_GET['idAsesor'];
    $_SESSION['asesoria']['idAlumno'] = $idAlumno = (int) $_GET['idAlumno'];
    $_SESSION['asesoria']['idIntegrantes'] = $idIntegrantes = (int)$_GET['idIntegrantes'];
    $_SESSION['asesoria']['idTipo'] = $idTipoAsesoria = (int) $_GET['idTipoAsesoria'];
    $_SESSION['asesoria']['idMotivo'] = $idMotivoAsesoria = (int) $_GET['idMotivoAsesoria'];
    $_SESSION['asesoria']['fecha'] = $fecha;
    $_SESSION['asesoria']['observaciones'] = $observaciones;
    // Otras variables
    $integrantes = $idIntegrantes === 1 ? 'Solo' : 'Con Padres';
    $tipo = $asesoria_model->getTipoById($idTipoAsesoria);
    $motivo = $asesoria_model->getMotivo($idMotivoAsesoria);
    $fecha = $_SESSION['asesoria']['fecha'];
    $observaciones = $_SESSION['asesoria']['observaciones'];

    $step++; // To step 6
  }
  // Step 6
  if (isset($_POST['subir'])) {
    if ($asesoria_model->insertAsesoria($_SESSION['asesoria'])) {
      $step = 7; // Final step
    } else {
      echo 'error';
    }
    unset($_SESSION['asesoria']);
  }
?>

<?php if ($step === 1): ?>
<div class="container">
  <h4 class="display-4 text-center">Registro de nueva asesoría</h4>
  <br>
  <h4 class="text-center">Escriba el nombre del alumno</h4>
  <div class="row justify-content-center">
    <input id="search" type="text" size="50" style="text-align:center;" placeholder="Escriba aquí">
  </div>
  <br>
  <div class="row justify-content-center">
    <div class="col-md-10">
      <table id="houdini" class="table table-striped table-dark table-sm table-bordered" style="visibility: collapse;">
        <thead>
          <th scope="col">Alumno</th>
          <th scope="col">Escuela</th>
          <th scope="col">Grupo</th>
        </thead>
        <tbody id="filter"> 
          <?php foreach ($alumnosDeAsesor as $fila): ?>
            <tr>
              <td data-href="<?=$current_page?>" data-id="<?=$fila['id']?>" class="align-middle">
                <?=$fila['Alumno']?>
              </td>
              <td class="align-middle"><?php echo $fila['Escuela']; ?></td>
              <td class="align-middle"><?php echo $fila['Grupo']; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody> 
      </table> 
      
      <div class="row my-4 justify-content-center">
        <div class="col-sm-3">
          <button class="btn btn-danger btn-lg btn-primary btn-block text-uppercase" onclick="window.location.href='asesor_dashboard.php?inputMail=<?=$asesor['correo'] ?>'">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="js/houdini.js"></script>
<script>
  $(document).ready(function() {
    $(document.body).on('click', 'td[data-href]', function() {
      window.location.href = this.dataset.href + "&idAlumno=" + this.dataset.id;
    })
  })
</script>

<?php elseif ($step === 2): ?>
<div class="container">
  <h4 class="display-4 text-center">Nueva asesoría con:</h4>
  <br>
  <h4 class="text-center"><?=$alumno['Alumno']?></h4>
  <div class="row justify-content-center">
    <div class="col-md-10">
      <form>
        <div class="row my-4 justify-content-center">
          <div class="col-sm-8">
            <label for="input-escuela">Escuela</label>
            <input class="form-control" placeholder="<?=$alumno['nombreEscuela']?>" disabled>
            <label for="input-grupo">Grupo</label>
            <input class="form-control" placeholder="<?=$alumno['Grupo']?>" disabled>
          </div><!--col-->
        </div><!--row-->
        <div class="row my-4 justify-content-center">
          <strong>Seleccione si la asesoría fue:</strong>
        </div><!--row-->
        <div class="row justify-content-center">
          <div class="col-sm-8">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="integrantes" value="1" id="solo" checked>
              <label class="form-check-label" for="solo">Solo Alumno</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="integrantes" value="2" id="padres">
              <label class="form-check-label" for="padres">Con Padres</label>
            </div>
          </div><!--col-->
        </div><!--row-->
      </form>
    </div><!--col-->
  </div><!--row-->
  <div class="row my-4 justify-content-center">
    <div class="col-sm-3">
      <button class="btn btn-danger btn-lg btn-primary btn-block text-uppercase" 
        onclick="window.location.href='asesor_dashboard.php?inputMail=<?php echo $mail; ?>'">Cancelar</button>
    </div><!--col-->
    <div class="col-sm-3">
      <button data-href="<?=$current_page?>" class="btn btn-success btn-lg btn-primary btn-block text-uppercase">Continuar</button>
    </div><!--col-->
  </div><!--row-->
</div><!--container-->
<script>
  $(document).ready(function() {
    $(document.body).on('click', 'button[data-href]', function () {
      var idIntegrantes = $('input[name="integrantes"]:checked').val()
      if(idIntegrantes === undefined) {
        alert("Por favor selecciona una de las opciones");
      } else {
        window.location.href = this.dataset.href + "&idIntegrantes=" + idIntegrantes;
      }
    })
  })
</script>

<?php elseif ($step === 3): ?>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <h4 class="display-4 text-center">Nueva asesoría con:</h4>
      <br>
      <h4 class="text-center"><?php echo $alumno['Alumno']; ?></h4>
      <br>
      <form onsubmit="return validateForm()">
      <div class="row justify-content-center">
        <label for="input-tipo">Tipo de Asesoría</label>
      </div>
        <div class="row justify-content-center">
          <div class="col-sm-8 col-md-4">
            <div class="row">
              <select id="tipoAsesoria" class="form-control">
              <?php foreach ($tiposAsesoria as $fila): ?>
                <option value="<?php echo $fila['id']; ?>"><?php echo $fila['tipo']; ?></option>
              <?php endforeach; ?>
              </select>
              <br>
            </div><!--row-->
          </div><!--col-->
        </div><!--row-->
      </form>

      <div class="row my-4 justify-content-center">
        <div class="col-sm-3">
          <button class="btn btn-danger btn-lg btn-primary btn-block text-uppercase" onclick="window.location.href='asesor_dashboard.php?inputMail=<?=$asesor['correo'] ?>'">Cancelar</button>
        </div><!--col-->
        <div class="col-sm-3">
          <button data-href="<?=$current_page?>" 
            class="btn btn-success btn-lg btn-primary btn-block text-uppercase">Aceptar</button>
        </div><!--col-->
      </div><!--row-->
    </div><!--col-->
  </div><!--row-->
</div><!--container-->
<script>
  $(document).ready(function () {
    $(document.body).on('click', 'button[data-href]', function () {
      window.location.href = this.dataset.href + "&idTipoAsesoria=" + $('#tipoAsesoria').val()
    })
  })
</script>

<?php elseif ($step === 4): ?>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <h4 class="display-4 text-center">Nueva asesoría con:</h4>
        <br>
        <h4 class="text-center"><?php echo $alumno['Alumno']; ?></h4>
        <br>
        <form onsubmit="return validateForm()">
          <div class="row justify-content-center">
            <label for="input-tipo">Motivo de Asesoría</label>
          </div><!--row-->
          <div class="row justify-content-center">
            <div class="col-md-8">
              <div class="row">
                <select id="motivoAsesoria" class="form-control">
                  <?php foreach ($motivosAsesoria as $fila): ?>
                    <option value="<?php echo $fila['id']; ?>"><?php echo $fila['motivo']; ?></option>
                  <?php endforeach; ?>
                </select>
                <br>
              </div><!--row-->
            </div><!--col-->
          </div><!--row-->
        </form>
        <div class="row my-4 justify-content-center">
          <div class="col-sm-3">
            <button class="btn btn-danger btn-lg btn-primary btn-block text-uppercase" 
              onclick="window.location.href='asesor_dashboard.php?inputMail=<?=$asesor['correo'] ?>'"
            >Cancelar
            </button>
          </div><!--col-->
          <div class="col-sm-3">
            <button data-href="<?=$current_page?>" 
              class="btn btn-success btn-lg btn-primary btn-block text-uppercase">Aceptar</button>
          </div><!--col-->
        </div><!--row-->
      </div><!--col-->
    </div><!--row-->
  </div><!--container-->

  <script>
    $(document).ready(function () {
      $(document.body).on('click', 'button[data-href]', function () {
        window.location.href = this.dataset.href + "&idMotivoAsesoria=" + $('#motivoAsesoria').val()
      })
    })
  </script>

<?php elseif ($step === 5): ?>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <h4 class="display-4 text-center">Nueva asesoría con:</h4>
        <br>
        <h4 class="text-center"><?php echo $alumno['Alumno']; ?></h4>
        <br>
        <form method="post" action="" id="insertForm">

        <div class="text-center">
          <div class="col-sm-2"></div>
            <label for="input-fecha">Fecha de la asesoría</label>
            <br>
            <input name="fecha" type="date" value="<?php echo date("Y-m-d")?>">
            <br>
            <br>
            <label for="input-observaciones">Observaciones</label>
            <br>
            <textarea name="observaciones" rows="10" cols="100" placeholder="Escribe aquí"></textarea>
            <br>
          <div class="col-sm-2"></div>
        </div>

        <div class="row my-4 justify-content-center">
          <div class="col-sm-3">
            <button type="button" class="btn btn-danger btn-lg btn-primary btn-block text-uppercase" onclick="window.location.href='asesor_dashboard.php?inputMail=<?php echo $mail; ?>'">Cancelar</button>
          </div>
          <div class="col-sm-3">
            <button type="submit" class="btn btn-success btn-lg btn-primary btn-block text-uppercase" name="aceptar" form="insertForm">Aceptar</button>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>

<?php elseif ($step === 6): ?>
  <div class="container">
    
    <h4 class="display-4 text-center">Resumen de asesoría con:</h4>
    <br>
    <h4 class="text-center"><?php echo $alumno['Alumno']; ?></h4>
    <div class="row justify-content-center">
      <div class="col-md-10">
          <div class="row my-4 justify-content-center">
            <div class="col-sm-8">
              <label for="input-escuela">Escuela</label>
              <input class="form-control" placeholder="<?=$alumno['nombreEscuela']?>" disabled>
              <label for="input-grupo">Grupo</label>
              <input id="input-grupo" class="form-control" placeholder="<?=$alumno['Grupo']?>" disabled>
              <label for="input-integrantes">Integrantes de la asesoría</label>
              <input id="input-integrantes" class="form-control" placeholder="<?=$integrantes?>" disabled>
              <label for="input-tipo">Tipo de asesoría</label>
              <input id="input-tipo" class="form-control" placeholder="<?=$tipo?>" disabled>
              <label for="input-motivo">Motivo de asesoría</label>
              <input id="input-motivo" class="form-control" placeholder="<?=$motivo?>" disabled>
              <label for="input-fecha">Fecha</label>
              <input id="input-fecha" class="form-control" placeholder="<?=$fecha ?>" disabled>
              <label for="input-observaciones">Observaciones</label>
              <input id="input-observaciones" class="form-control" placeholder="<?=$observaciones ?>" disabled>
              </div>
          </div>
        <form method="post">
          <div class="row my-4 justify-content-center">
            <div class="col-sm-8">
              <button type="submit" class="btn btn-success btn-lg btn-primary btn-block text-uppercase"     
                name="subir">Subir asesoría</button>
            </div>
          </div>
        </form>
        <div class="row my-4 justify-content-center">
          <div class="col-sm-5">
            <button class="btn btn-danger btn-lg btn-primary btn-block text-uppercase" 
              onclick="window.location.href='asesor_dashboard.php?inputMail=<?=$mail?>'">Cancelar</button>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php elseif ($step === 7): ?>
  <div class="container">
    <div class="alert alert-success" role="alert">Asesoría cargada con éxito</div>
    <br>
      <div class="row justify-content-center">
        <div class="col-md-4">
          <div class="row">
            <button class="btn-b blue-gradient btn-block p-3" 
              onclick="window.location.href='asesor_dashboard.php?inputMail=<?=$mail?>'">
              Regresar al menu principal</button>
          </div>
        </div>
      </div>
  </div>
</body>
</html>
<?php endif;?>


</body>
</html>