<style>
  td[data-href] {
    cursor: pointer;
  }

  td[data-href]:hover {
    background-color: #33a652;
  }
</style>

<?php
include 'navbar_admin.php';


$where = "WHERE TRUE";

$asesor = !empty($_POST['asesor']) ? $_POST['asesor'] : "";
$sede = !empty($_POST['sede']) ? $_POST['sede'] : "";
$escuela = !empty($_POST['escuela']) ? $_POST['escuela'] : "";
$anio = !empty($_POST['anio']) ? $_POST['anio'] : "";
// $semestre = !empty($_POST['semestre']) ? $_POST['semestre'] : "";
$mes = !empty($_POST['mes']) ? $_POST['mes'] : "";
$rangoDeFechasInicio = !empty($_POST['rangoDeFechasInicio']) ? $_POST['rangoDeFechasInicio'] : "";
$rangoDeFechasFin = !empty($_POST['rangoDeFechasFin']) ? $_POST['rangoDeFechasFin'] : "";

if (isset($_POST['filtrar'])) {

  if ($asesor) $where .= " AND Asesor.nombre = '" . $asesor . "' ";
  if ($sede) $where .= " AND Localidad.idLocalidad = " . $sede . " ";
  if ($escuela) $where .= " AND Escuela.idEscuela = " . $escuela . " ";
  if ($anio) $where .= " AND YEAR(Asesoria.fecha) = '" . $anio . "' ";
  if ($mes) $where .= " AND MONTH(Asesoria.fecha) = " . $mes;
  if (isset($_POST['filtroFecha']) && $rangoDeFechasInicio && $rangoDeFechasFin) {
    $where .= " AND Asesoria.fecha BETWEEN '$rangoDeFechasInicio' AND '$rangoDeFechasFin'";
  }

}

?>

<div class="container">
  <h4 class="display-4 text-center">Historial de asesorías</h4>
  <br>
  <br>
  <div class="row">
    <form method="POST">
      <div class="row mb-3">
        <div class="col-sm-12">
          <h5>FILTROS</h5>
        </div>
        <div class="col-sm-3">
          <select id="filtroAsesor" class="form-control" name="asesor">
            <option value="" selected>Facilitador</option>
            <?php
            include '../config/Conn.php';
            $resultado = $conn->query("SELECT nombre FROM Asesor");
            $resultado->data_seek(0);
            while ($fila = $resultado->fetch_assoc()) {
              $nombreAsesor = $fila['nombre'];
            ?>
              <option value="<?php echo $nombreAsesor; ?>"><?php echo $nombreAsesor; ?></option>
            <?php
            }
            $conn->close();
            ?>
          </select>
        </div>
        <div class="col-sm-3">
          <select id="filtroSede" class="form-control" name="sede">
            <option value="" selected>Sede</option>
            <?php
            include '../config/Conn.php';
            $resultado = $conn->query("SELECT idLocalidad, nombre FROM Localidad");
            $resultado->data_seek(0);
            while ($fila = $resultado->fetch_assoc()) {
              $idLocalidad = $fila['idLocalidad'];
              $nombreSede = $fila['nombre'];
            ?>
              <option value="<?php echo $idLocalidad; ?>"><?php echo $nombreSede; ?></option>
            <?php
            }
            $conn->close();
            ?>
          </select>
        </div>
        <div class="col-sm-3">
          <select id="filtroEscuela" class="form-control" name="escuela">
            <option value="" selected>Escuela</option>
            <?php
            include '../config/Conn.php';
            $resultado = $conn->query("SELECT idEscuela, nombre FROM Escuela");
            $resultado->data_seek(0);
            while ($fila = $resultado->fetch_assoc()) {
              $idEscuela = $fila['idEscuela'];
              $nombreEscuela = $fila['nombre'];
            ?>
              <option value="<?php echo $idEscuela; ?>"><?=$nombreEscuela?></option>
            <?php
            }
            $conn->close();
            ?>
          </select>
        </div>
        <div class="col-sm-3">
          <select id="filtroAnio" class="form-control" name="anio">
            <option value="" selected>Año</option>
            <?php
            include '../config/Conn.php';
            $resultado = $conn->query("SELECT DISTINCT YEAR(fecha) AS ano FROM Asesoria");
            $resultado->data_seek(0);
            while ($fila = $resultado->fetch_assoc()) {
              $ano = $fila['ano'];
            ?>
              <option value="<?php echo $ano; ?>"><?=$ano?></option>
            <?php
            }
            $conn->close();
            ?>
          </select>
        </div>
      </div>
      <div class="row mb-3">
        <!-- <div class="col-sm-3">
          <select id="filtroSemestre" class="form-control" name="semestre">
            <option value="" selected>Semestre</option>
            <option value="EJ20">Enero-Junio 2020</option>
            <option value="JD19">Julio-Agosto 2019</option>
            <option value="EJ20">Enero-Junio 2019</option>
            <option value="JD18">Julio-Agosto 2018</option>
            <option value="EJ20">Enero-Junio 2018</option>
            <option value="JD17">Julio-Agosto 2017</option>
            <option value="EJ20">Enero-Junio 2017</option>
            <option value="JD16">Julio-Agosto 2016</option>
            <option value="EJ16">Enero-Junio 2016</option>
          </select>
        </div> -->
        <div class="col-sm-3">
          <select id="filtroMes" class="form-control" name="mes">
            <option value="" selected>Mes</option>
            <option value="1">Enero</option>
            <option value="2">Febrero</option>
            <option value="3">Marzo</option>
            <option value="4">Abril</option>
            <option value="5">Mayo</option>
            <option value="6">Junio</option>
            <option value="7">Julio</option>
            <option value="8">Agosto</option>
            <option value="9">Septiembre</option>
            <option value="10">Octubre</option>
            <option value="11">Noviembre</option>
            <option value="12">Diciembre</option>
          </select>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-sm-12">
          <h5>FILTRAR POR FECHA</h5>
          <input type="checkbox" name="filtroFecha" id="filtroFecha">
        </div>
        <div id="rangoDeFechas" class="form-group col-sm-5">
            <input id="rangoDate" type="text" autocomplete="off" name="fechas" class="form-control">
            <input id="resultStart" type="hidden" name="rangoDeFechasInicio">
            <input id="resultEnd" type="hidden" name="rangoDeFechasFin">
        </div>
      </div>
      <div class="row">
        <div class="col-sm-2">
          <button name="filtrar" type="submit" class="btn btn-success">FILTRAR</button>
        </div>
      </div>
    </form>
  </div>
  <div class="row">
      <form action="exportar_csv.php?where=<?=$where?>" method="post">
        <input type="submit" name="exportar" value="Exportar CSV" class="btn btn-warning">
        <input type="hidden" name="where" value="<?=$where?>">
      </form>
  </div>
  <br>
  <div class="row">

    <h5>ASESORÍAS</h5>
    <div class="table-responsive">
    <table class="table table-striped table-dark table-sm table-bordered" style="table-layout: fixed;">
        <thead>
          <th scope="col">ID</th>
          <th scope="col">Alumno</th>
          <th scope="col">Facilitador</th>
          <th scope="col">Fecha</th>
          <th scope="col">Motivo</th>
          <th scope="col">Dinámica</th>
          <th scope="col">Observaciones</th>
        </thead>
        <tbody id="pagination">
          <?php
          include '../config/Conn.php';
          $query =
            "SELECT
                Asesoria.idAsesoria AS idAsesoria
                , Alumno.idAlumno AS idAlumno
                , CONCAT(Alumno.nombre,' ',Alumno.apellido) AS alumno
                , Asesor.idAsesor AS idAsesor
                , Asesor.nombre AS asesor
                , DATE_FORMAT(Asesoria.fecha, '%d-%m-%Y') AS fecha
                , Motivo.motivo AS motivo
                , Integrantes.descripcion AS dinamica
                , Asesoria.observaciones AS observaciones
            FROM Asesoria
            JOIN Alumno on Alumno.idAlumno = Asesoria.idAlumno
            JOIN Asesor on Asesor.idAsesor = Asesoria.idAsesor
            JOIN Motivo on Motivo.idMotivo = Asesoria.idMotivo
            JOIN Integrantes on Integrantes.idIntegrantes = Asesoria.idIntegrantes
            JOIN Turno on Turno.idAsesor = Asesor.idAsesor
            JOIN Escuela on Escuela.idEscuela = Turno.idTurno
            JOIN Localidad on Localidad.idLocalidad = Escuela.idLocalidad
            $where
            ORDER BY Asesoria.idAsesoria DESC";

          $resultado = $conn->query($query);
          if (!$resultado) {
            echo "ERROR: " . $conn->error;
          }
          if (!$resultado->fetch_array()) {
            echo "<tr><td colspan='7'>AUN NO HAY ASESORIAS REGISTRADAS</td></tr>";
          } else {

            $resultado->data_seek(0);

            while ($fila = $resultado->fetch_assoc()) {
          ?>
              <tr>
                <td class="align-middle text-truncate"><?php echo $fila['idAsesoria']; ?></td>
                <td data-alumno="" data-href="alumno_historial.php" data-id="<?php echo $fila['idAlumno']; ?>" class="align-middle text-truncate"><?php echo $fila['alumno']; ?></td>
                <td data-asesor="" data-href="asesorias_facilitador.php" data-id="<?php echo $fila['idAsesor']; ?>" class="align-middle text-truncate"><?php echo $fila['asesor']; ?></td>
                <td class="align-middle text-truncate"><?php echo $fila['fecha']; ?></td>
                <td data-motivo="<?=$fila['motivo']; ?>" class="linkToModal align-middle text-truncate"><?php echo $fila['motivo']; ?></td>
                <td class="align-middle text-truncate"><?php echo $fila['dinamica']; ?></td>
                <td data-obs="<?=$fila['observaciones']; ?>" class="linkToModal align-middle text-truncate"><?php echo $fila['observaciones']; ?></td>
              </tr>
          <?php
            }
          }
          $conn->close();
          ?>
        </tbody>
      </table>
    </div>

    <div class="col-md-12 text-center">
      <ul class="pagination pagination-lg pager" id="pagination_page"></ul>
    </div>

    <h5>ESTADÍSTICAS</h5>
    <div class="table-responsive">
    <table class="table table-striped table-dark table-sm table-bordered" style="table-layout: fixed;">
        <thead>
          <th scope="col">Total de asesorías</th>
          <th scope="col">Total de alumnos atendidos</th>
          <th scope="col">Total de asesorías con alumnos</th>
          <th scope="col">Total de asesorías con padres</th>
        </thead>
        <tbody>
          <?php
          include '../config/Conn.php';
          $query =
            "SELECT COUNT(Asesoria.idAsesoria) AS totalAsesorias,
                    COUNT(DISTINCT Asesoria.idAlumno) AS totalAlumnos,
                    COUNT(DISTINCT CASE WHEN Asesoria.idIntegrantes = 1 THEN Asesoria.idAsesoria END) AS totalConAlumno,
                    COUNT(DISTINCT CASE WHEN Asesoria.idIntegrantes = 2 THEN Asesoria.idAsesoria END) AS totalConPadres
            FROM Asesoria
            JOIN Alumno on Alumno.idAlumno = Asesoria.idAlumno
            JOIN Asesor on Asesor.idAsesor = Asesoria.idAsesor
            JOIN Motivo on Motivo.idMotivo = Asesoria.idMotivo
            JOIN Integrantes on Integrantes.idIntegrantes = Asesoria.idIntegrantes
            JOIN Turno on Turno.idAsesor = Asesor.idAsesor
            JOIN Escuela on Escuela.idEscuela = Turno.idTurno
            JOIN Localidad on Localidad.idLocalidad = Escuela.idLocalidad
            $where";

          $resultado = $conn->query($query);
          if (!$resultado) {
            echo "ERROR: " . $conn->error;
          }
          if ($resultado->fetch_array()) {

            $resultado->data_seek(0);

            while ($fila = $resultado->fetch_assoc()) {
          ?>
              <tr>
                <td class="align-middle text-truncate"><?php echo $fila['totalAsesorias']; ?></td>
                <td class="align-middle text-truncate"><?php echo $fila['totalAlumnos']; ?></td>
                <td class="align-middle text-truncate"><?php echo $fila['totalConAlumno']; ?></td>
                <td class="align-middle text-truncate"><?php echo $fila['totalConPadres']; ?></td>
              </tr>
          <?php
            }
          }
          $conn->close();
          ?>
        </tbody>
      </table>
    </div>

    <div class="row">
      <button class="btn-b aqua-gradient btn-block p-3" onclick="window.location.href='admin_dashboard.php'">
        Regresar
      </button>
      <br>
    </div>

  </div>
</div>

<?php include "../modal_obs.php" ?>
<?php include "../modal_motivo.php" ?>

<script src="../paginacion/bootstrap-table-pagination.js"></script>
<script src="../paginacion/pagination.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
  $(document).ready(function() {
    $(document.body).on("click", "td[data-alumno]", function() {
      window.location.href = this.dataset.href + "?idAlumno=" + this.dataset.id;
    });
    $(document.body).on("click", "td[data-asesor]", function() {
      window.location.href = this.dataset.href + "?idUsuario=" + this.dataset.id;
    });
    $(document.body).on("click", "td[data-motivo]", function() {
      $("#modalMotivo .modal-body").html(this.dataset.motivo);
      $("#modalMotivo").modal("show");
    });
    $(document.body).on("click", "td[data-obs]", function() {
      $("#modalObservacion .modal-body").html(this.dataset.obs);
      $("#modalObservacion").modal("show");
    });
  });
</script>

<script src="../js/filtrosPorFecha.js"></script>

</body>

</html>