<?php include 'navbar_admin.php';
    $idUsuario = (int)$_GET['idUsuario'];
?>

<?php

$oldNombre = "";
$oldCorreo = "";

include '../config/Conn.php';
$query = "SELECT ass.nombre AS Asesor, ass.correo AS Correo
    FROM Asesor as ass
    WHERE ass.idAsesor = $idUsuario";
    $resultado = $conn->query($query);
    if ($resultado) {
        $resultado->data_seek(0);
        $fila = $resultado->fetch_assoc();
        $oldNombre = $fila['Asesor'];
        $oldCorreo = $fila['Correo'];
    } else {
        echo "ERROR: " . $conn->error . "ON: \n";
        echo $query;
    }
    $conn->close();


?>

<?php

if (isset($_POST['subir'])) {
  $nombre = $_POST['nombre'];
  $correo = $_POST['correo'];
  if($nombre === $oldNombre || $nombre === "") {
    $nombre = $oldNombre;
  }

  if($correo === $oldCorreo || $correo === "") {
    $correo = $oldCorreo;
  }
  include '../config/Conn.php';
  $query = "UPDATE Asesor SET nombre='" . $nombre . "', correo='" . $correo . "' WHERE idAsesor = $idUsuario";
  if ($conn->query($query) === TRUE) {
    $message = "Cambios guardados con éxito";
    echo "<script type='text/javascript'>alert('$message');</script>";
    echo "<script type='text/javascript'> document.location = 'admin_facilitadores.php'; </script>";
  } else {
    echo "Error: " . $query . "<br>" . $conn->error;
  }

  $conn->close();
}
?>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10">
          <h4 class="display-4 text-center">Editando usuario</h4>
          <br>
          <h4 class="text-center">Editando a:&nbsp;<?php echo $fila['Asesor']; ?></h4>
          <form method="post" action="" id="insertForm" onsubmit="return validateForm()">

          <div class="row my-4">
            <div class="col-sm-2"></div>
              <div class="col-sm-8">
                <label for="input-nombre">Nombre</label>
                <input type="input-nombre" class="form-control" name="nombre" placeholder="<?php echo $oldNombre; ?>">
                <br>
                <label for="input-correo">Correo</label>
                <input type="input-correo" class="form-control" name="correo" placeholder="<?php echo $oldCorreo; ?>" >
               </div>
              <div class="col-sm-2"></div>
            </div>
          </form>
        
        
        <div class="row my-4 justify-content-center">
          <div class="col-sm-3">
            <button class="btn btn-success btn-lg btn-primary btn-block text-uppercase" name="subir" form="insertForm" >Aceptar</button>
          </div>
          <div class="col-sm-3">
            <button class="btn btn-danger btn-lg btn-primary btn-block text-uppercase" onclick="window.location.href='admin_facilitadores.php'">Cancelar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>