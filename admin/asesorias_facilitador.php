<?php include 'navbar_admin.php';

$asesor_model = new Asesor;
$asesoria_model = new Asesoria;

$idAsesor = (int) $_GET['idUsuario'];
$asesor = $asesor_model->getAsesorById($idAsesor);

$asesorias_asesor = $asesoria_model->getAsesoriasDeAsesor($idAsesor);

if (isset($_POST['filtrar'])) {
    if ($_POST['mes']) {
        $where .= " AND MONTH(Asesoria.fecha) = " . $_POST['mes'];
    }    
}

?>

<div class="container">
    <h4 class="display-4 text-center">Historial de asesorías</h4>
    <br>
    <h4 class="text-center">Historial de facilitador:&nbsp;<?php echo $asesor['nombre'];?></h4>
          
    <div class="row">
        <form method="POST">

            <div class="row">
                <div class="col-sm-12">
                    <h4>FILTROS</h4>
                </div>

                <div class="col-sm-4">

                    <select id="motivoAsesoria" class="form-control" name="mes">
                        <option selected>Mes</option>
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
    <div class="row">
        <h5>ASESORÍAS</h5>
        <div class="table-responsive">
            <table class="table-pagination table table-striped table-dark table-sm table-bordered" 
                style="table-layout: fixed;">
                <thead>
                    <th scope="col">ID</th>
                    <th scope="col">Alumno</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Motivo</th>
                    <th scope="col">Dinámica</th>
                    <th scope="col">Observaciones</th>
                </thead>
                <tbody id="pagination">
                    <?php foreach ($asesorias_asesor as $fila): ?>
                        <tr>
                            <td class="align-middle text-truncate"><?php echo $fila['idAsesoria']; ?></td>
                            <td class="align-middle text-truncate"><?php echo $fila['Alumno']; ?></td>
                            <td class="align-middle text-truncate"><?php echo $fila['Fecha']; ?></td>
                            <td data-motivo="<?=$fila['Motivo']; ?>" class="linkToModal align-middle text-truncate"><?php echo $fila['Motivo']; ?></td>
                            <td class="align-middle text-truncate"><?php echo $fila['Dinamica']; ?></td>
                            <td data-obs="<?=$fila['Observaciones']; ?>" class="linkToModal align-middle text-truncate"><?php echo $fila['Observaciones']; ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>

        <div class="row">
            <button class="btn-b aqua-gradient btn-block p-3" onclick="window.location.href='admin_facilitadores.php'">Regresar</button><br>
        </div>
    </div>
</div>

<?php include "../modal_obs.php" ?>
<?php include "../modal_motivo.php" ?>
<?php include '../bootstrap_js.php' ?>
<script src="../js/paginacion/tablePagination.js"></script>
<script src="../js/paginacion/index.js"></script>

<script>
    $(document).ready(function() {
        $(document.body).on("click", "td[data-href]", function() {
            window.location.href = this.dataset.href + "?idAlumno=" + this.dataset.id;
        });
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