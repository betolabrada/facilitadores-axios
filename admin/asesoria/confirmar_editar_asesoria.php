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

var_dump($asesoria)

?>

<h3><?php echo "Esta seguro que desea modificar esta asesoria?"?></h3> 

<form action="editar_asesoria.php" method="POST">
    <li>
        <ul>Nombre del Alumno: <?php echo $_POST['nombreAlumno']?></ul> 
        <ul>Fecha: <input type="date" name="fecha" value="<?php echo $asesoria[0]['fecha']?>"/></ul>
        <ul>Observaciones: <input type="text" name="observaciones" value="<?php echo $asesoria[0]['observaciones']?>"/></ul>
        <!--Ver la manera de hacer este campo de texto más grande-->
        Sólo alumno <input type="radio" name="integrantes" value="1" <?php echo $asesoria[0]['idIntegrantes'] == "1"?'checked/"checked/"':'' ?>>
        Con padres <input type="radio" name="integrantes" value="2" <?php echo $asesoria[0]['idIntegrantes'] == "2"?'checked/"checked/"':'' ?>>
     </li>
    <input type="number" name="idAsesoria" value="<?php echo $_POST['idAsesoria']?>" hidden="hidden"/>
    <input type="submit" value="Aceptar"/>
</form>
<form action="../../asesor_dashboard.php?inputMail=<?php echo $mail?>" method="POST">
    <input type="submit" value="Cancelar"/>
</form>
