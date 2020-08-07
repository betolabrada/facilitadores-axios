<?php

session_start();
if (isset($_SESSION['admin'])) {
  include 'navbar_admin.php';
} else {
  include '../asesor_navbar.php';
}

require_once '../models/Escuela.php';

$escuela_model = new Escuela;

$idEscuela = (int) $_POST['id'];
echo $idEscuela;

$escuela_model->deleteEscuela($idEscuela);

header("Location: admin_dashboard.php");
