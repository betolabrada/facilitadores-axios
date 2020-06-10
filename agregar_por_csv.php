<?php

    include 'config/Conn.php';
    
    if (!isset($_GET['id'])) {
        $grupoId = 1;
    } else {
        $grupoId = $_GET['id'];
    }
    
    if (isset($_POST['importar'])) {
        $filename = $_FILES['archivo']['tmp_name'];

        if ($_FILES['archivo']['size'] > 0) {
            $file = fopen($filename, "r");

            while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
                $sql = "INSERT INTO Alumno (noLista, nombre, apellido, idGrupo) 
                VALUES (". $column[0] . ",'" . utf8_encode($column[1]) . "','" . 
                    utf8_encode($column[2]) . "'," . $grupoId . ")";

                $result = $conn->query($sql);

                if (!$result) {
                    echo "ERROR EN QUERY: " . $sql;
                    echo $conn->error;
                    break;
                }
            }
            fclose($file);
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>SUBIR ARCHIVO</title>
</head>
<body>
    <div class="container">
        <form id="#formCSVImport" method="POST" name="subirCSV" enctype="multipart/form-data">
            <div class="row mb-3">
                
            </div>
            <div class="row mb-3">
                <label for="inputArchivo" class="col-sm-2 col-form-label">Subir archivo CSV</label>
                <div class="col-sm-4">
                    <input type="file" name="archivo" id="inputArchivo" accept=".csv">
                </div>
                <div class="col-sm-4">
                    <button type="submit" id="submit" name="importar" class="btn btn-success">Importar Alumnos</button>
                </div>
            </div>
        </form>

    <?php
    // query 1 get asesor de grupo
    $sql = "SELECT 
            grup.grupo, a.nombre, e.nombre as nombreEscuela, t.tipo, t.descripcion, e.numero, l.nombre as sede
        FROM Grupo grup 
            JOIN Grado grad on grad.idGrado = grup.idGrado 
            JOIN Turno t on t.idTurno = grad.idTurno 
            JOIN Asesor a on a.idAsesor = t.idAsesor 
            JOIN Escuela e on e.idEscuela = t.idEscuela
            JOIN Localidad l on l.idLocalidad = e.idLocalidad
        WHERE idGrupo =" . $grupoId;
    
    $result = $conn->query($sql);
    if ($result) {
        $row = $result->fetch_assoc();
        echo "<p>Grupo: <strong>" . $row['grupo'] . "</strong></p>";
        echo "<p>Asesor: <strong> " . $row['nombre'] . "</strong></p>";
        echo "<p>Escuela: <strong> " . $row['nombreEscuela'] . "</strong></p>";
        echo "<p>Turno: <strong> " . $row['tipo'] . "</strong></p>";
        echo "<p>Descripcion: <strong> " . $row['numero'] . " ". $row['sede'] . " " . $row['descripcion']  . "</strong></p>";

    }
    else {
        echo $conn->error;
        echo $sql;
    }

    

    // query 2 alumnos ya subidos
    $sql = "SELECT * FROM Alumno WHERE idGrupo = " . $grupoId . " ORDER BY idAlumno";
    $result = $conn->query($sql);
    if ($result) {
        $result->data_seek(0);
        if ($result->num_rows > 0) {
    ?>
    <table id="alumnos-subidos">
        <thead>
            <tr>
                <th>ID ALUMNO</th>
                <th>No. LISTA</th>
                <th>NOMBRE(s)</th>
                <th>APELLIDOS</th>
            </tr>
        </thead>
        <?php 
        }
            while ($fila = $result->fetch_assoc()) {
        ?>
        <tbody>
            <tr>
                <td><?=$fila['idAlumno']?></td>
                <td><?=$fila['noLista']?></td>
                <td><?=$fila['nombre']?></td>
                <td><?=$fila['apellido']?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php }
        $conn->close();
    ?>
    </div>
</body>
</html>

