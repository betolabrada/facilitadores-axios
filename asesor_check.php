<?php
 session_start();
 if(!isset($_SESSION['user'])){
   header('location: index.php');
 }

 $usuario = $_SESSION['user'];
?>