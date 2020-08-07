<?php
require_once 'config/db.php'; 
require_once 'lib/Database.php'; 

session_start();
if(!isset($_SESSION['user'])){
  header('location: index.php');
}

$usuario = $_SESSION['user'];

spl_autoload_register(function($class) {
  require_once 'models/' . $class . '.php';
});
?>