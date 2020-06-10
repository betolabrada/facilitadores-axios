<?php

//  DATOS DEL SERVIDOR
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "axios";

//  CONEXION AL SERVIDOR
$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}else{
    //echo("Conexión exitosa <br>");
    mysqli_select_db($conn, $db_name);
    if ($result = mysqli_query($conn, "SELECT DATABASE()")) {
        $row = mysqli_fetch_row($result);
        //printf("Default database is %s.\n", $row[0]);
        mysqli_free_result($result);

    }else{
        echo "Error al conectarse a la base de datos";
    }
}

?>
