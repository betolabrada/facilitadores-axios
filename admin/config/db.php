<?php

$host = "localhost";
$username = "facilit1_admin";
$password = "ALPQD3CbBmtUzjV";
$dbname = "facilit1_axios_dev_db";

try {
  $con = new PDO("mysql:host={$host};dbname={$dbname}", $username, $password);
} 
catch (PDOException $exception) {
  echo "Connection error: " . $exception->getMessage();
}

?>