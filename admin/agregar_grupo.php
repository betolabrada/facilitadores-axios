<?php
session_start();
if (isset($_SESSION['admin'])) {
  include 'navbar_admin.php';
} else {
  include '../asesor_navbar.php';
}

require_once '../models/Asesoria.php';

$grupo_model = new Grupo();

$grupo_model->addGrupo($_POST['nombre'], $_POST['turno']);

$mail = $_SESSION['user'];

header("Location: ../admin/admin_dashboard.php");