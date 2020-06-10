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

$idAlumno = (int) $_GET['idAlumno'];
$where = "WHERE Alumno.idAlumno = $idAlumno";
// $idAsesor = (int)$_GET['idUsuario'];
$mes = !empty($_POST['mes']) ? $_POST['mes'] : "";

include '../config/Conn.php';
$queryId = "SELECT CONCAT(a.nombre,' ', a.apellido) AS nombre FROM Alumno a WHERE idAlumno = '$idAlumno'";
$resultadoId = $conn->query($queryId);
$resultadoId->data_seek(0);
$filaId = $resultadoId->fetch_assoc();
$nombre = $filaId['nombre'];
$conn->close();

if (isset($_POST['filtrar'])) {
    if ($mes) $where .= " AND MONTH(Asesoria.fecha) = " . $mes;
}

?>

<div class="container">
    <h4 class="display-4 text-center">Historial de asesorías</h4>
    <br>
    <h4 class="text-center">Historial de alumno:<br /><?php echo $nombre; ?></h4>
    <br>
    <div class="row">
        <form method="POST">

            <div class="row">
                <div class="col-sm-12">
                    <h5>FILTROS</h5>
                </div>

                <div class="col-sm-4">

                    <select id="motivoAsesoria" class="form-control" name="mes">
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
                <div class="col-sm-4">
                    <button name="filtrar" type="submit" class="btn btn-success">FILTRAR</button>
                </div>
            </div>
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
                <tbody>
                    <?php
                    include '../config/Conn.php';
                    $query = "SELECT 
                      Asesoria.idAsesoria AS idAsesoria 
                      , Alumno.idAlumno AS idAlumno 
                      , CONCAT(Alumno.nombre,' ',Alumno.apellido) AS Alumno
                      , Asesor.idAsesor AS idAsesor
                      , Asesor.nombre AS Asesor
                      , DATE_FORMAT(Asesoria.fecha, '%d-%m-%Y') AS Fecha 
                      , Motivo.motivo AS Motivo
                      , Integrantes.descripcion AS Dinamica 
                      , Asesoria.observaciones AS Observaciones
                  FROM Asesoria 
                  JOIN Alumno on Alumno.idAlumno = Asesoria.idAlumno 
                  JOIN Asesor on Asesor.idAsesor = Asesoria.idAsesor 
                  JOIN Motivo on Motivo.idMotivo = Asesoria.idMotivo 
                  JOIN Integrantes on Integrantes.idIntegrantes = Asesoria.idIntegrantes
                  $where
                  ORDER BY Asesoria.idAsesoria DESC";

                    $resultado = $conn->query($query);
                    if (!$resultado) {
                        echo "ERROR: " . $conn->error;
                    }
                    if (!$resultado->fetch_array()) {
                        echo "<tr><td colspan='5'>AUN NO HAY ASESORIAS REGISTRADAS</td></tr>";
                    } else {

                        $resultado->data_seek(0);

                        while ($fila = $resultado->fetch_assoc()) {
                    ?>
                            <tr>
                                <td class="align-middle text-truncate"><?php echo $fila['idAsesoria']; ?></td>
                                <td class="align-middle text-truncate"><?php echo $fila['Alumno']; ?></td>
                                <td class="align-middle text-truncate"><?php echo $fila['Asesor']; ?></td>
                                <td class="align-middle text-truncate"><?php echo $fila['Fecha']; ?></td>
                                <td data-motivo="<?=$fila['Motivo']; ?>" class="linkToModal align-middle text-truncate"><?php echo $fila['Motivo']; ?></td>
                                <td class="align-middle text-truncate"><?php echo $fila['Dinamica']; ?></td>
                                <td data-obs="<?=$fila['Observaciones']; ?>" class="linkToModal align-middle text-truncate"><?php echo $fila['Observaciones']; ?></td>
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

        <div class="row">
            <button class="btn-b purple-gradient btn-block p-3" onclick="window.location.href='admin_asesorias.php'">Regresar</button><br>
        </div>
    </div>
</div>

<?php include '../modal_obs.php' ?>
<?php include "../modal_motivo.php" ?>

<script src="../paginacion/bootstrap-table-pagination.js"></script>
<script src="../paginacion/pagination.js"></script>
<script>
    $(document).ready(function() {
        $(document.body).on("click", "td[data-obs]", function() {
            $("#modalObservacion .modal-body").html(this.dataset.obs);
            $("#modalObservacion").modal("show");
        });  
        $(document.body).on("click", "td[data-motivo]", function() {
            $("#modalMotivo .modal-body").html(this.dataset.motivo);
            $("#modalMotivo").modal("show");
        });
    });
</script>

</body>

</html>