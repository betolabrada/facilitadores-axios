<?php

// Variables
include 'config.php';

// Autoload
spl_autoload_register(function ($class_name) {
    include '../lib/' . $class_name . '.php';
});

$db = new Database();