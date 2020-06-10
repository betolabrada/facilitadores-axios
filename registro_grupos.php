<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Registro de Grupos</title>
  <link rel="stylesheet" href="sauce/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <meta name="viewport" content="width=device-width, initial-scale=1,
      shrink-to-fit=no">

</head>

<body>

  <script src="sauce/grupos.js"></script>


  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03"
      aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">
      <img src="sauce/Logo AXIOS.png" width="50" height="50" class="d-inline-block align-top" alt="">
    </a>

    <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
      <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
        <li class="nav-item active">
          <a class="nav-link" href="#">Inicio<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Hola <h7 id="hola"></h7> </a>
        </li>
      </ul>

      <button class="btn" type="submit" onclick="cerrar()">Cerrar Sesión</button>

    </div>
  </nav>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <h1>Registro de Grupos</h1>

        <div class="form-label-group">
          <div class="row my-4 justify-content-center">
            <div class="col-sm-8">
              <label for="inputEmail">Escriba nombre de la escuela</label>
              <input type="text" id="inputAlumno" class="form-control" placeholder="Nombre" required autofocus>
            </div>
          </div>
          <div class="row my-4">
            <div class="col-sm-2"></div>
            <div class="col-sm-4">
              <label for="input-grado">Grado</label>
              <input type="input-grado" class="form-control" placeholder="grado" required>
              <label for="input-tipo">Facilitador</label>
              <select id="tipoAsesoria" class="form-control"></select>
            </div>
            <div class="col-sm-4">
              <label for="input-grupo">Grupo</label>
              <input type="input-grupo" class="form-control" placeholder="grupo" required>
            </div>
            <div class="col-sm-2"></div>
          </div>
        </div>
        <form>
          <div class="row justify-content-center">
            <h4 for="archivo">Archivo</h4>
            <div class="col-sm-4">
              <input type="file" class="form-control-file" id="inputArchivo">
            </div>
          </div>
        </form>
        <div class="row my-4 justify-content-center">
          <div class="col-sm-3">
            <button class="btn btn-success btn-lg btn-primary btn-block text-uppercase">Aceptar</button>
          </div>
          <div class="col-sm-3">
            <button class="btn btn-danger btn-lg btn-primary btn-block text-uppercase">Cancelar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>