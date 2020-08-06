<?php 
include 'asesor_navbar.php';

require_once 'models/Asesor.php';

$asesor_model = new Asesor();

$idAsesor = $_GET['id'];

$entradas = $asesor_model->getEntradas($idAsesor);

?>

<div class="container">
    <button class="btn-b peach-gradient btn-block p-3" 
        onclick="window.location.href='registro_diario.php?id=<?=$idAsesor?>'">
        Nueva Entrada
    </button>
    <div class="table-responsive">
        <table class="table table-striped table-dark table-sm table-bordered" style="table-layout: fixed;">
            <thead>
                <th scope="col">Grupo</th>
                <th scope="col">Fecha</th>
                <th scope="col">Anotación</th>
            </thead>
            <tbody>
            <?php foreach ($entradas as $fila): ?>
                <tr>
                    <td class="align-middle text-truncate"><?=$fila['Grupo']?></td>
                    <td class="align-middle text-truncate"><?=$fila['Fecha']?></td>
                    <td data-anotacion="<?=$fila['Anotacion']?>" class="linkToModal align-middle text-truncate">
                        <?=$fila['Anotacion']?>
                    </td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
    </div>
    <?php include 'modal_anotacion.php'; ?>
    
</div>

<script>
    $(document.body).on("click", "td[data-anotacion]", function() {
      $("#modalAnotacion .modal-body").html(this.dataset.anotacion);
      $("#modalAnotacion").modal("show");
    });
</script>