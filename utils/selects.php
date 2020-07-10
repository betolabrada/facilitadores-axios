<!-- FILTRO ASESOR -->
<select id="filtroAsesor" class="form-control" name="asesor">
  <option value="" selected>Facilitador</option>
  <?php foreach ($asesores as $fila): ?>
  <?php if (isSelected()): ?>
  <option value="<?=$fila['idAsesor'] ?>" selected><?=$fila['nombre'] ?></option>
  <?php else:?>
  <option value="<?=$fila['idAsesor'] ?>"><?=$fila['nombre'] ?></option>
  <?php endif;?>
  <?php endforeach; ?>
</select>

<!-- FILTRO SEDE -->
<select id="filtroSede" class="form-control" name="sede">
  <option value="" selected>Sede</option>
  <?php foreach ($sedes as $fila): ?>
    <?php if (isSelected()): ?>
      <option value="<?=$fila['idLocalidad'] ?>" selected><?=$fila['nombre'] ?></option>
    <?php else: ?>
      <option value="<?=$fila['idLocalidad'] ?>"><?=$fila['nombre'] ?></option>
    <?php endif; ?>
  <?php endforeach; ?>
</select>

<!-- FILTRO Escuela -->
<select id="filtroEscuela" class="form-control" name="escuela">
  <option value="" selected>Escuela</option>
  <?php foreach ($escuelas as $fila): ?>
    <?php if (isSelected()): ?>
      <option value="<?=$fila['idEscuela'] ?>" selected><?=$fila['nombre'] ?></option>
    <?php else: ?>
      <option value="<?=$fila['idEscuela'] ?>"><?=$fila['nombre'] ?></option>
    <?php endif; ?>
  <?php endforeach; ?>
</select>