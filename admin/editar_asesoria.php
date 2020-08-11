<?php

session_start();
if (isset($_SESSION['admin'])) {
  include 'navbar_admin.php';
} else {
  include '../asesor_navbar.php';
}

require_once '../models/Asesoria.php';

var_dump($_POST);

$asesoria_model = new Asesoria();

$idAsesoria = (int) $_POST['idAsesoria'];

$asesoria_model->updateAsesoriaById('fecha',$_POST['fecha'],(int) $_POST['idAsesoria']);
$asesoria_model->updateAsesoriaById('idIntegrantes',$_POST['integrantes'],(int) $_POST['idAsesoria']);
$asesoria_model->updateAsesoriaById('observaciones',$_POST['observaciones'],(int) $_POST['idAsesoria']);

$mail = $_SESSION['user'];

header("Location: ../asesor_dashboard.php?inputMail=$mail");