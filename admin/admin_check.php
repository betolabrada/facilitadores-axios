<?php
  session_start();
  if(!isset($_SESSION['admin'])){
    header('location: ../index.php');
  }

  require_once '../config/db.php'; 
  require_once '../lib/Database.php'; 

  spl_autoload_register(function($class) {
    require_once '../models/' . $class . '.php';
  });
?>