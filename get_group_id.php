<?php
    include 'config/Conn.php';

    $sql = "SELECT nombre FROM Escuela";

    if ($result = $conn->query($sql)) {
        $result->data_seek(0);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="sauce/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>SELECCIONA GRUPO</title>
</head>
<body>
  <div class="container">
    <h2 class="text-center my-4">NUEVA LISTA</h2>
    <form>
      <div class="form-group row">
        <label for="select-escuela" class="col-sm-2 col-form-label">Escuela</label>
        <div class="col-sm-8">
          <select class="custom-select mr-sm-2" id="select-escuela" name="escuela">
            <option selected>Seleccione...</option>
            <?php 
            $valueNo = 1;
            while ($fila = $result->fetch_assoc()) {
              echo '<option value="' . $valueNo . '">' . $fila['nombre'] . '</option>';
              $valueNo++;
            }
            ?>
          </select>
        </div>
      </div>
      <fieldset name="turno" class="form-group">
        <div class="row">
          <legend class="col-form-label col-sm-2 pt-0">Turno</legend>
          <div class="col-sm-10">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="turno" id="turno1" value="M" checked>
              <label class="form-check-label" for="turno1">
                Matutino
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="turno" id="turno2" value="V">
              <label class="form-check-label" for="turno2">
                Vespertino
              </label>
            </div>
          </div>
        </div>
      </fieldset>
      <fieldset name="grado" class="form-group">
        <div class="row">
          <legend class="col-form-label col-sm-2 pt-0">Grado</legend>
          <div class="col-sm-10">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="option1" checked>
              <label class="form-check-label" for="gridRadios1">
                1°
              </label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="option2">
              <label class="form-check-label" for="gridRadios2">
                2°
              </label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="option2">
              <label class="form-check-label" for="gridRadios2">
                3°
              </label>
            </div>
          </div>
        </div>
      </fieldset>
      <div class="form-group row">
        <label for="select-grupo" class="col-sm-2 col-form-label">Grupo</label>
        <div class="col-sm-2">
          <select name="grupo" class="custom-select mr-sm-2" id="select-escuela">
            <option selected>Seleccione...</option>
            <option value="1">A</option>
            <option value="2">B</option>
            <option value="3">C</option>
            <option value="4">D</option>
            <option value="5">E</option>
            <option value="6">F</option>
          </select>
        </div>
      </div>
      
      <div class="form-group row text-center">
        <div class="col-sm-12">
          <button type="submit" name="submitButton" class="btn btn-primary px-5">Continuar</button>
        </div>
      </div>
    </form>
  </div>
</body>

<?php 

  if (isset($_POST['submitButton'])) {
      $query = '';

      if($conn->query($query) == true) {
          echo "actualizado correctamente";
      }
      else {
          echo "ERROR: " . $conn->error;
      };
  }
  
  $conn->close();
  ?>
</html>