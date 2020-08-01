<?php include 'navbar_admin.php'; 

/**
 * //////////////////////IMPORTANTE///////////////////////////////////
 * Esta codigo se creo pero no es accesible dentro de la pagina web, este codigo
 * es importante para la autonomia pero en este periodo se nos pidio no seguir
 * con ello, espero el codigo sea lo más claro posible y suerte apoyando a esta
 * causa. Besos en el yoyopo :D
 */

?>

<div class="container">
  <h4 class="display-4 text-center">Agregar Localidad</h4>
  <br>
    <div class="row justify-content-center">
      <div class="col-md-10">
        <form method="post" action="agregar_localidad.php" id="insertForm">
            <div class="row my-4">
              <div class="col-sm-2"></div>
              <div class="col-sm-8">
                <label for="input-nombre">Nombre</label>
                <input type="input-nombre" class="form-control" name="nombre" required="required">
              </div>
            </div>
        </form>
        <div class="row my-4 justify-content-center">
          <div class="col-sm-3">
            <button class="btn btn-success btn-lg btn-primary btn-block text-uppercase" name="subir" form="insertForm">Agregar</button>
          </div>
          <div class="col-sm-3">
            <button class="btn btn-danger btn-lg btn-primary btn-block text-uppercase" onclick="window.location.href='admin_sedes.php'">Cancelar</button>
          </div>
        </div>
    </div>
  </div>
</body>
</html> 