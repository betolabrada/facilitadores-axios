<form method="POST" id="filtros">
  <?php if (!isset($idAsesor)): ?>
  <div class="row mb-3">
    <div class="col-sm-12">
      <h5>FILTROS</h5>
    </div>
    <div class="col-sm-3">
    <!-- FILTRO ASESOR -->
      <select id="filtroAsesor" class="form-control" name="asesor">
        <option value="" selected>Facilitador</option>
        <?php foreach ($asesores as $fila): ?>
        <?php if (isset($post_asesor) && $post_asesor == $fila['idAsesor']): ?>
        <option value="<?=$fila['idAsesor'] ?>" selected><?=$fila['nombre'] ?></option>
        <?php else:?>
        <option value="<?=$fila['idAsesor'] ?>"><?=$fila['nombre'] ?></option>
        <?php endif;?>
        <?php endforeach; ?>
      </select>
    </div><!--col-sm-3-->
    <div class="col-sm-3">
    <!-- FILTRO SEDE -->
      <select id="filtroSede" class="form-control" name="sede">
        <option value="" selected>Sede</option>
        <?php foreach ($sedes as $fila): ?>
          <?php if (isset($post_sede) && $post_sede == $fila['idLocalidad']): ?>
            <option value="<?=$fila['idLocalidad'] ?>" selected><?=$fila['nombre'] ?></option>
          <?php else: ?>
            <option value="<?=$fila['idLocalidad'] ?>"><?=$fila['nombre'] ?></option>
          <?php endif; ?>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-sm-3">
      <select id="filtroEscuela" class="form-control" name="escuela">
        <option value="" selected>Escuela</option>
        <?php foreach ($escuelas as $fila): ?>
          <?php if (isset($post_escuela) && $post_escuela == $fila['idEscuela']): ?>
            <option value="<?=$fila['idEscuela'] ?>" selected><?=$fila['nombre'] ?></option>
          <?php else: ?>
            <option value="<?=$fila['idEscuela'] ?>"><?=$fila['nombre'] ?></option>
          <?php endif; ?>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <?php endif; ?>
  
  <div class="row">
    <div class="col-sm-2">
      <button name="filtrar" type="submit" class="btn btn-success">FILTRAR</button>
    </div>
  </div>
</form>