<?php
include 'navbar_admin.php';


$turno_model = new Turno();

if ($turno_model->deleteTurno($_GET['idTurno'])) {
    echo 'Borrado exitoso';
} else {
    echo 'error';
}


?>



<button type="button" class="btn btn-primary" 
    onclick="window.location.href='admin_turnos.php'">Regresar</button>