<?php include 'asesor_navbar.php';

require_once 'models/Asesor.php';
require_once 'models/Asesoria.php';

$asesor_model = new Asesor();
$asesoria_model = new Asesoria();

$mail = $_GET['inputMail'];

$asesor = $asesor_model->getAsesorByEmail($mail);
$idAsesor = $asesor['idAsesor'];

$u_asesoriasDeAsesor = $asesoria_model->ultimasAsesoriasDeAsesor($idAsesor);

?>

<div class="container p-5">
  <div class="row p-2">
    <div class="col-md-6">
      <button class="btn-b peach-gradient btn-block p-3" 
        onclick="window.location.href='registro_aseso.php?idAsesor=<?=$idAsesor; ?>'">
          Registrar Asesoría</button>
    </div>
    <div class="col-md-6">
      <button class="btn-b purple-gradient btn-block p-3" 
        onclick="window.location.href='asesor_historial.php?idAsesor=<?=$idAsesor; ?>'">
          Historial</button><br>
    </div>
  </div>
  <div class="row p-2">
    <div class="col-md-6">
      <button class="btn-b blue-gradient btn-block p-3" 
        onclick="window.location.href='diario_de_campo.php?idAsesor=<?=$idAsesor?>'">
        Diario de Campo
      </button>
    </div>
  </div>
</div>
<div class="container">
  <div class="row">
    <h5>ÚLTIMAS ASESORÍAS</h5>
      <div class="table-responsive">
        <table class="table table-striped table-dark table-sm table-bordered" style="table-layout: fixed;">
          <thead>
            <th scope="col">Alumno</th>
            <th scope="col">Fecha</th>
            <th scope="col">Motivo</th>
            <th scope="col">Dinámica</th>
            <th scope="col">Observaciones</th>
          </thead>
          <tbody>
            <?php foreach ($u_asesoriasDeAsesor as $fila): ?>
              <tr>
                <td data-href="alumno_historial.php" data-id="<?php echo $fila['id']; ?>" class="align-middle text-truncate"><?php echo $fila['Alumno']; ?></td>
                <td class="align-middle text-truncate"><?php echo $fila['Fecha']; ?></td>
                <td class="align-middle text-truncate"><?php echo $fila['Motivo']; ?></td>
                <td class="align-middle text-truncate"><?php echo $fila['Dinamica']; ?></td>
                <td class="align-middle text-truncate"><?php echo $fila['Observaciones']; ?></td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
      <button class="btn-b aqua-gradient btn-block p-3" onclick="window.location.href='asesor_historial.php?idAsesor=<?php echo $idAsesor; ?>'">VER TODAS</button>
    </div>
  </div>

  <script>
    $(document).ready(function () {
        $(document.body).on("click", "td[data-href]", function () {
          window.location.href = this.dataset.href + "?idAsesor=" + <?php echo(json_encode($idAsesor)); ?> + "&idAlumno="+ this.dataset.id;
        });
    });
  </script>
</body>
</html>