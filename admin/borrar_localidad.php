<?php

include 'navbar_admin.php';

$sede_model = new Sede();

if ($sede_model->removeSede($_POST['idSede'])) {
    echo 'Borrado exitoso';
} else {
    echo 'error';
}

?>

<button type="button" class="btn btn-primary" onclick="window.location.href='admin_sedes.php'">Regresar</button>