<?php 
include 'asesor_navbar.php';

require_once 'models/Asesor.php';

$asesor_model = new Asesor;

$gruposDeAsesor = $asesor_model->getGruposDeAsesor($_GET['id']);

// print_r($_POST);
if (isset($_POST['subir'])) {
    if ($asesor_model->insertarNuevaEntrada($_GET['id'], $_POST)) {
        echo "datos subidos correctamente";
        header('Location: diario_de_campo.php?id=' . $_GET['id']);
    } else {
        echo "ERROR";
    }
}

?>

<div class="container">
    <form method="post">
    <select id="grupoDeAsesor" class="form-control" name="grupo">
        <option value="" selected>Grupo</option>
        <?php foreach ($gruposDeAsesor as $fila): ?>
            <option value="<?=$fila['idGrupo'] ?>"><?=$fila['grupo'] ?></option>
        <?php endforeach; ?>
    </select>

    <div class="form-group">
        <label for="anotacionTextArea">Escribe aquí tus anotaciones</label>
        <textarea class="form-control" id="anotacionTextArea" name="anotacion" rows="3"></textarea>
    </div>

    <button class="btn-b aqua-gradient btn-block p-3" type="submit" name="subir">Subir</button><br>
    </form>
</div>
