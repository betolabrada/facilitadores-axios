<?php

session_start();
if (isset($_SESSION['admin'])) {
  include '../navbar_admin.php';
} else {
  include '../../asesor_navbar.php';
}

require_once '../../models/Asesoria.php';

$asesoria_model = new Asesoria();

$idAsesoria = (int) $_POST['idAsesoria'];

$asesoria = $asesoria_model->getAsesoriaById($idAsesoria);

$mail = $_SESSION['user'];

?>

<h3><?php echo "Esta seguro que desea borrar esta asesoria?"?></h3>
<li>
    <ul>Nombre del Alumno: <?php echo $_POST['nombreAlumno']?></ul>
    <ul>Fecha: <?php echo $asesoria[0]['fecha']?></ul>
    <ul>Observaciones: <?php echo $asesoria[0]['observaciones']?></ul>
</li>
<form action="borrar_asesoria.php" method="POST">
    <input type="number" name="idAsesoria" value="<?php echo $_POST['idAsesoria']?>" hidden="hidden"/>
    <input type="submit" value="Aceptar"/>
</form>
<form action="../../asesor_dashboard.php?inputMail=<?php echo $mail?>" method="POST">
    <input type="submit" value="Cancelar"/>
</form>