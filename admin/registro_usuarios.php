<?php include 'navbar_admin.php';

if (isset($_POST['registrar'])) {
  $name = $_POST['inputName'];
  $email = $_POST['inputEmail'];
  $pass = $_POST['inputPassword'];

  include '../config/Conn.php';
  $query = "INSERT INTO Asesor (idAsesor, nombre, correo, `password`) VALUES (NULL, '$name', '$email', PASSWORD('$pass'))";
  if ($conn->query($query) === TRUE) {
    $message = "Usuario registrado con éxito";
    echo "<script type='text/javascript'>alert('$message');</script>";
    echo "<script type='text/javascript'> document.location = 'admin_facilitadores.php'; </script>";
  } else {
    $message = "Error: " . $query . "<br>" . $conn->error;
    echo "<script type='text/javascript'>alert('$message');</script>";
  }
  $conn->close();
}

?>

  <div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card card-signin my-5">
          <div class="card-body text-center">
            <img src="../assets/logo.png" class="img-responsive" style="width:100px;" /><br>
            <h5 class="card-title text-center">Registro de Asesores</h5>
            <form method="post" action="" class="form-signup" id="form-signup">
              <div class="form-label-group">
                <input type="name" id="inputName" name="inputName" class="form-control" placeholder="Nombre" required
                  autofocus>
                <label for="inputName">Nombre</label>
              </div>

              <div class="form-label-group">
                <input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Correo Electrónico" required
                  autofocus>
                <label for="inputEmail">Correo Electrónico</label>
              </div>

              <div class="form-label-group">
                <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Contraseña" required>
                <label for="inputPassword">Contraseña</label>
              </div>

              <button role="button" class="btn btn-lg btn-primary btn-block text-uppercase" name="registrar">Registrar</button>
              <button role="button" class="btn btn-lg btn-primary btn-block text-uppercase" name="cancelar" onclick="window.location.href='admin_facilitadores.php'">Cancelar</button>
              <hr class="my-4">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>