<?php
    //  DATOS DEL SERVIDOR
    $servername = "localhost";
    $username = "facilit1_admin";
    $password = "ALPQD3CbBmtUzjV";
    $dbname = "facilit1_axios_dev_db";

    //  CONEXION AL SERVIDOR
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
    /*else{
        echo "Conexion exitosa\n";
    }*/

    $sql = "SELECT idEscuela, nombre, idLocalidad FROM Escuela";
    $result = $conn->query($sql);
    $output = array();

    while($row = $result->fetch_array()){
        array_push($output,$row);
    }
    
    echo json_encode($output);

    $conn->close();



?>