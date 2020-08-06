<?php
include 'init.php';

$asesor = new Asesor();

if(isset($_GET['cerrar_sesion'])){
  session_unset();
  session_destroy();
}

if(isset($_SESSION['user'])){
  if(isset($_SESSION['admin'])){
    header('location: admin_dashboard.php');
  }else if (isset($_SESSION['facilit'])){
    header('location: asesor_dashboard.php?inputMail=' . $_SESSION['user'] . '');
  } else {
    header('location: index.php');
  }
}

if (isset($_POST['inputEmail']) && isset($_POST['inputPassword'])) {
  $mail = $_POST['inputEmail'];
  $pass = $_POST['inputPassword'];

  $loggedIn = $asesor->login($mail, $pass);

  if($loggedIn){
    $_SESSION['user'] = $loggedIn['correo'];
    if(substr($mail,0,5) === "admin"){
      $_SESSION['admin'] = true;
      header('location: admin_dashboard.php');
    }else{
      $_SESSION['facilit'] = true;
      header('location: asesor_dashboard.php?inputMail=' . $_SESSION['user']);
    }
  }else{
    echo '<script>alert("Usuario y/o contraseña incorrecto(s)");</script>';
  }

}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Login</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <meta name="viewport" content="width=device-width, initial-scale=1,
    shrink-to-fit=no">
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card card-signin my-5">
          <div class="card-body text-center">
            <img src="assets/logo.png" class="img-responsive" style="width:100px;" /><br>
            <h5 class="card-title text-center">Control de Asesorías</h5>

            <form class="form-signin" id="form-signin" action="" method="post">
              <div class="form-label-group">
                <input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Correo Electrónico" required autofocus>
                <label for="inputEmail">Correo Electrónico</label>
              </div>

              <div class="form-label-group">
                <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Contraseña" required>
                <label for="inputPassword">Contraseña</label>
              </div>


              <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit" value="Submit">Ingresar</button>
              <hr class="my-4">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>
</html>