<?php include 'navbar_admin.php'; ?>
<div class="container">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h5 class="display-4 text-center">USUARIOS</h5>
        </div>
    </div>
</div>

<div class="container text-center">
    <div class="row">
        <a role="button" href="registro_usuarios.php" class="btn btn-success">AÑADIR FACILITADOR</a>
        <br>
        <div class="table-responsive">
            <table class="table table-striped table-dark table-sm table-bordered">
                <thead>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Asesorías</th>
                    <th scope="col">Editar</th>
                    <th scope="col">Nueva contraseña</th>
                    <th scope="col">Eliminar</th>
                </thead>
                <tbody>
                    <?php
                    include '../config/Conn.php';

                    $resultado = $conn->query("SELECT * FROM Asesor ORDER BY Asesor.idAsesor ASC");

                    $resultado->data_seek(0);
                    while ($fila = $resultado->fetch_assoc()) {
                        $nombreAsesor = $fila['nombre'];
                        ?>
                        <tr>
                            <td class="align-middle"><?php echo $fila['idAsesor']; ?></td>
                            <td class="align-middle"><?php echo $fila['nombre']; ?></td>
                            <td class="align-middle"><?php echo $fila['correo']; ?></td>
                            <td class="align-middle"><a role="button" href="asesorias_facilitador.php?idUsuario=<?php echo $fila['idAsesor']; ?>" class=" btn btn-primary">Historial</a></td>
                            <td class="align-middle"><a role="button" href="editar_facilitador.php?idUsuario=<?php echo $fila['idAsesor']; ?>" class=" btn btn-danger">Editar</a></td>
                            <td class="align-middle"><a role="button" href="editar_password.php?idUsuario=<?php echo $fila['idAsesor']; ?>" class=" btn btn-danger">Nueva contraseña</a></td>
                            <td class="align-middle"><a role="button" href="borrar_facilitador.php?idUsuario=<?php echo $fila['idAsesor']; ?>" class=" btn btn-danger">Eliminar</a></td>
                        </tr>
                    <?php
                    }
                    $conn->close();

                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-lg-2">
            <div class="row">
                <button class="btn-b aqua-gradient btn-block p-3" onclick="window.location.href='admin_dashboard.php'">Regresar</button><br>
            </div>
    </div>
    
</div>


</body>
</html>