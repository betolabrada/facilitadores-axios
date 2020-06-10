<?php include 'navbar_admin.php'; ?>

<div class="container text-center">
    
    <div class="container">
        <div class="row">
            <div class="col-lg-2">
                <div class="row">
                    <button class="btn-b aqua-gradient btn-block p-3" onclick="window.location.href='admin_dashboard.php'">Regresar</button><br>
                </div>
            </div>
            <div class="col-lg-8 text-center">
                <h5 class="display-4 text-center">SEDES</h5>
            </div>
        </div>
    </div>
    <div class="row">
        <?php
        include '../config/Conn.php';

        $resultado = $conn->query("SELECT * FROM Localidad");
        //$numSedes = $resultado->num_rows;

        $resultado->data_seek(0);
        while ($fila = $resultado->fetch_assoc()) {
            $nombreSede = $fila['nombre'];
            $idSede = $fila['idLocalidad'];
            echo "<button class='btn-b blue-gradient p-3' style='width:30%;'>" . $nombreSede . "</button>";
            echo "<input type='hidden' id='sede" . $idSede . "'  value='" . $idSede . "'>";
        }
        $conn->close();

        ?>

    </div>
    
    <div class="container">
        <div class="table-responsive">
            <table>
                <thead>
                    <th scope="col">NOMBRE</th>
                </thead>
                <tbody>
                    <?php
                    include '../config/Conn.php';
                    //echo "ESCUELAS <br>";
                    $res2 = $conn->prepare(("SELECT * FROM Escuela WHERE idLocalidad = 1 "));
                    //$res2->bind_param("i", 1);
                    $res2->execute();
                    $datos = $res2->get_result();

                    $res2->data_seek(0);
                    while ($escuelas = $datos->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $escuelas['nombre']; ?></td>
                            <td>asdsade</td>
                        </tr>
                    <?php
                    }
                    $res2->close();

                    ?>


                </tbody>
            </table>
            
        </div>
        
    </div>
</div>

</body>
<script>
    function showSede() {


    }
</script>
</html>