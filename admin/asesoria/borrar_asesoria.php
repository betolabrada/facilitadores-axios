<?php

session_start();
if (isset($_SESSION['admin'])) {
  include 'navbar_admin.php';
} else {
  include '../../asesor_navbar.php';
}

require_once '../../models/Asesoria.php';

$asesoria_model = new Asesoria();

$idAsesoria = (int) $_POST['idAsesoria'];

$asesoria_model->deleteAsesoria($idAsesoria);

$mail = $_SESSION['user'];

header("Location: ../../asesor_dashboard.php?inputMail=$mail");