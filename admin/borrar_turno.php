<?php
include 'navbar_admin.php';

$turno_model = new Turno();

if (isset($_POST['borrar'])) {
    if ($turno_model->deleteTurno($_GET['idTurno'])) {
        $_SESSION['message'] = 'Borrado exitoso';
    } else {
        echo 'error';
    }
}

?>


<div class="container">
    <?php if (isset($_SESSION['message'])):?>
    <div class="alert alert-danger" role="alert">
      <?=$_SESSION['message'] ?>
    </div>
    <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
    <div class="row my-5">
        <!-- Button trigger modal -->
        <div class="col-sm-6">
          <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#exampleModal">
            Click para borrar turno
          </button>
        </div>
        <div class="col-sm-6">
            <button type="button" class="btn btn-primary" 
                onclick="window.location.href='admin_turnos.php'">Regresar</button>
        </div>
    </div>
</div>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" 
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Borrar lista</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <p>¿Seguro(a) que quieres borrar este turno?
              Los datos se borrarán para SIEMPRE y será IMPOSIBLE recuperarlos.</p>
            </div>
          </div>
          <form id="deleteForm" method="post"></form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" name="borrar" form="deleteForm" class="btn btn-danger">
            Estoy seguro(a), borrar</button>
        </div><!--modal-footer-->
      </div><!--modal-content-->
    </div><!--modal-dialog-->
  </div><!--modal-fade-->

<?php include '../bootstrap_js.php'; ?>