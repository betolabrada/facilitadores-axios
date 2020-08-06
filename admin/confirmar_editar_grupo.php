<?php

include 'navbar_admin.php'; 
require_once '../models/Grupo.php';

$grupo_model = new Grupo;

$grupo = $grupo_model->getGroupById($_POST['idGrupo']);

require_once '../models/Turno.php';

$turno =  new Turno;

$turnos = $turno->getTurnos();

$selected = false;

?>

<div class="container">
  <h4 class="display-4 text-center">Editar Grupo</h4>
  <br>
    <div class="row justify-content-center">
      <div class="col-md-10">
        <form method="post" action="editar_grupo.php" id="insertForm">
            <div class="row my-4">
              <div class="col-sm-2"></div>
              <div class="col-sm-8">
                <label for="input-nombre">Nombre</label>
                <input type="input-nombre" class="form-control" name="nombre" required="required" value='<?php echo $grupo[0]['grupo']?>'>
              </div>
            </div>
            <div class="row my-4">
              <div class="col-sm-2"></div>
              <div class="col-sm-8">
                <label for="input-turno">Grado</label>
                <select id="input-turno" class="form-control" name="turno">
                    <?php foreach ($turnos as $fila): ?>
                    <?php if ($selected==false): $selected=true;?>
                    <option value="<?=$fila['idTurno'] ?>" selected><?php echo $fila['tipo'] . ", " . $fila['Escuela'] . ", " . $fila['nombre']?></option>
                    <?php else:?>
                    <option value="<?=$fila['idTurno'] ?>"><?=$fila['tipo'] . ", " . $fila['Escuela'] . ", " . $fila['nombre'] ?></option>
                    <?php endif;?>
                    <?php endforeach; ?>
                </select>
              </div>
            </div>
            <input type="text" value="<?php echo $_POST['idGrupo']?>" name="idGrupo" hidden="hidden"/>
        </form>
          
          <form action="borrar_grupo.php" method="POST" id='borrarForm'>
              <input type="text" value="<?php echo $_POST['idGrupo']?>" name="idGrupo" hidden="hidden"/>
          </form>
          
        <div class="row my-4 justify-content-center">
          <div class="col-sm-3">
            <button class="btn btn-success btn-lg btn-primary btn-block text-uppercase" form="insertForm">Actualizar</button>
          </div>
          <div class="col-sm-3">
            <button class="btn btn-danger btn-lg btn-primary btn-block text-uppercase" form='borrarForm'>Borrar grupo</button>
          </div>
        </div>
        <div class="row my-4 justify-content-center">
          <div class="col-sm-3">
            <button class="btn btn-danger btn-lg btn-primary btn-block text-uppercase" onclick="window.location.href='admin_grupos.php'">Cancelar</button>
          </div>
        </div>
    </div>
  </div>
</body>
</html> 