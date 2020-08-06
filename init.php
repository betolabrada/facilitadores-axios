<?php
session_start();
require_once 'config/db.php';
require_once 'lib/Database.php';
spl_autoload_register(function ($class_name) {
    include 'models/' . $class_name . '.php';
});

?>