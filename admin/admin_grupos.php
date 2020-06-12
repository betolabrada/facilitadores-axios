<?php include 'navbar_admin.php'; ?>
<?php include 'admin_grupos_proc.php'; ?>

<div class="container my-3">
  <?php if (isset($_SESSION['message'])):?>
  <div class="alert alert-danger">
  <?php
    echo $_SESSION['message'];
    unset($_SESSION['message']);
  ?>
  </div><!--alert-->
  <?php endif; ?>
  <div class="row">
    <div class="col-sm-4">
      <h4>Búsqueda</h4>
    </div>
  </div><!--row-->
  <form method="GET" action="admin_grupos.php">
    <div class="row mt-3">
      <div class="col-sm-6">
        <!-- First search filter: filtro escuela -->
        <select id="filtroEscuela" class="form-control" name="escuela">
          <option value="0">Escuela</option>
          <?php while ($fila = $escuelas->fetch_assoc()):?>
          <option value="<?=$fila['idEscuela']?>"><?=$fila['nombre']?></option>
          <?php endwhile; ?>
        </select>
      </div><!--col-->
      <div class="col-sm-3">
        <!-- Filtro turno -->
        <select id="filtroTurno" class="form-control" name="turno">
          <option value="0" selected>Turno</option>
          <option value="1">Matutino</option>
          <option value="2">Vespertino</option>
        </select>
      </div><!--col-->
      <div class="col-sm-3">
        <!-- Filtro grado -->
        <select id="filtroGrado" class="form-control" name="grado">
          <option value="" selected>Grado</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
        </select>
      </div><!--col-->
    </div><!--row-->
    <div class="row mt-3">
      <div class="col-sm-3">
        <!-- Filtro grupo -->
        <select id="filtroGrupo" class="form-control" name="grupo">
          <option value="0" selected>Grupo</option>
          <option value="A">A</option>
          <option value="B">B</option>
          <option value="C">C</option>
          <option value="D">D</option>
          <option value="E">E</option>
          <option value="F">F</option>
        </select>
      </div><!--col-->
    </div><!--row-->
    <div class="row mt-3">
      <div class="col-sm-12 d-flex justify-content-center">
        <button name="search" value="1" type="submit" class="btn btn-success flex-grow-1">Buscar Alumnos</button>
      </div>
    </div><!--row-->
  </form>
  <?php if ($busqueda && !isset($badRequest)):?>
  <div class="row mt-3">
    <?php if ($datos->num_rows == 0):?>
    <div class="col-sm-6 justify-content-center">
      <h3>No hay datos para enseñar</h3>
      <h3>Escuela:</h3>
      <p><?=getNombreEscuela($pEscuela)?></p>
      <h3>Grupo:</h3>
      <p><?=$pGrado . $pGrupo . " ". $pTurno ?></p>
      <h3>Grupo no existe</h3>
    </div>
    <?php elseif ($dato = $datos->fetch_assoc()):?>
    <div class="col-sm-6 justify-content-center">
      <h4><?=$dato['grupo']?> <?=$dato['nombreEscuela']?> <?=$dato['tipo']?></h4>
    </div>
    <div class="col-sm-3">
      <a href="agregar_por_csv.php?id=<?=$grupoId?>" class="btn btn-info btn-block">Actualizar grupo</a>
    </div>
    <?php else:?>
    <h3>Error</h3>
    <?php endif; ?>
  </div><!--row-->
  <?php endif;?>
  <?php if ($resultAlumnosSuccess):?>
  <div class="row justify-content-center mt-3">
    <table class="table table-sm">
      <thead>
        <tr>
          <th scope="col">No. LISTA</th>
          <th scope="col">NOMBRE(s)</th>
          <th scope="col">APELLIDOS</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($fila = $alumnos->fetch_assoc()):?>
        <tr>
          <td scope="row"><?=$fila['noLista']?></td>
          <td><?=$fila['nombre']?></td>
          <td><?=$fila['apellido']?></td>
        </tr>
        <?php endwhile;?>
      </tbody>
    </table>
  </div><!--row-->
  <?php endif;?>
</div><!--container-->
</body>
</html>