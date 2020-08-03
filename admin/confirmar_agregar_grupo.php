<?php

include 'navbar_admin.php'; 

?>

<div class="container">
  <h4 class="display-4 text-center">Agregar Grupo</h4>
  <br>
    <div class="row justify-content-center">
      <div class="col-md-10">
        <form method="post" action="agregar_grupo.php" id="insertForm">
            <div class="row my-4">
              <div class="col-sm-2"></div>
              <div class="col-sm-8">
                <label for="input-nombre">Nombre</label>
                <input type="input-nombre" class="form-control" name="nombre" required="required">
              </div>
            </div>
            <div class="row my-4">
              <div class="col-sm-2"></div>
              <div class="col-sm-8">
                <label for="input-turno">Grado</label>
                <select id="input-turno" class="form-control" name="grado">
                    <option value="1" selected="selected">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                </select>
              </div>
            </div>
        </form>
          
        <div class="row my-4 justify-content-center">
          <div class="col-sm-3">
            <button class="btn btn-success btn-lg btn-primary btn-block text-uppercase" form="insertForm">Crear Grupo</button>
          </div>
          <div class="col-sm-3">
            <button class="btn btn-danger btn-lg btn-primary btn-block text-uppercase" onclick="window.location.href='admin_grupos.php'">Cancelar</button>
          </div>
        </div>
    </div>
  </div>
</body>
</html> 
