<!DOCTYPE html>
<html lang="en">

<head>
  <title>Agregar Grupo</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>

<body>

  <div class="container">
    <div class="page-header">
      <h1>Crear Grupo</h1>
    </div>

    <?php
      include 'config/db.php';

      $stmt = $con->prepare("SELECT nombre FROM Localidad");

      $stmt->execute();

    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <table class='table table-hover table-responsive table-bordered'>
        <tr>
          <td>Zona Escolar</td>
          <td><select name="zonas">
            <?php
              while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                echo "<option value='$nombre'>$nombre</option>";
              }
            ?>
          </select></td>
        </tr>
        <tr>
          <td>Description</td>
          <td><textarea name='description' class='form-control'></textarea></td>
        </tr>
        <tr>
          <td>Price</td>
          <td><input type='text' name='price' class='form-control' /></td>
        </tr>
        <tr>
          <td></td>
          <td>
            <input type='submit' value='Save' class='btn btn-primary' />
            <a href='index.php' class='btn btn-danger'>Back to read products</a>
          </td>
        </tr>
      </table>
    </form>
  </div>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>