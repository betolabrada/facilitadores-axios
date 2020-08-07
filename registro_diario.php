<?php 
include 'asesor_navbar.php';

$idAsesor = $_GET['idAsesor'];
$asesor_model = new Asesor();
$grupo_model = new Grupo();
$turno_model = new Turno();
$turnos = $asesor_model->getTurnos($idAsesor);
$step = 1;
$go_back_url = 'diario_de_campo.php?idAsesor=' . $idAsesor;

if (isset($_POST['regresar'])) {
    $step = 1;
}

if (isset($_POST['validar'])) {
    print_r($_POST);
    $idTurno = $_POST['turno'];
    $grupo = strtoupper($_POST['grupo']);
    $idGrupo = $grupo_model->getGrupo($grupo, $idTurno);
    if ($idGrupo) {
        $step = 2;
        $_SESSION['idGrupo'] = $idGrupo;
        $turno = $turno_model->getTurnoById($idTurno);
    } else {
        $_SESSION['message'] = 'No se encontró grupo, reintentar';
    }
}
// print_r($_POST);
if (isset($_POST['subir'])) {
    $step = 2;
    $idGrupo = $_SESSION['idGrupo']['idGrupo'];
    if (empty($_POST['anotacion'])) {
        $_SESSION['message'] = 'Por favor escribe algo';
    } else {
        $anotacion = $_POST['anotacion'];
        if ($asesor_model->insertarNuevaEntrada($idAsesor, $idGrupo, $anotacion)) {
            $message = "Entrada subida correctamente";
            unset($_SESSION['idGrupo']);
            unset($_SESSION['message']);
            echo "<script type='text/javascript'>alert('$message');</script>";
            echo "<script type='text/javascript'>document.location='" . $go_back_url . "';</script>"; 
        } else {
            echo "ERROR";
        }
    }
}


?>

<div class="container">
    <?php if (isset($_SESSION['message'])) : ?>
        <div class="alert alert-warning" role="alert">
            <?=$_SESSION['message']?>
        </div>
    <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
    <?php if ($step === 1): ?>
    <form method="post">
        <div class="form-group">
            <label for="turnosDeAsesor">Selecciona el turno del Asesor</label>
            <select id="turnosDeAsesor" class="form-control" name="turno">
                <option value="" selected>Turno</option>
                <?php foreach ($turnos as $fila): ?>
                <option value="<?=$fila['idTurno'] ?>"><?=$fila['turno'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="grupoDeAsesor">Escribe el grupo que deseas registrar entrada de diario</label>
            <input type="text" class="form-control" id="grupoDeAsesor" aria-describedby="grupoHelp" 
                placeholder="Grupo" name="grupo">
            <small id="grupoHelp" class="form-text text-muted">Escribe un numero seguido de una letra</small>
        </div>
        <button class="btn-b aqua-gradient btn-block p-3" type="submit" name="validar">Siguiente</button>
    </form>
    <?php elseif ($step === 2):?>
    <h4>Grupo: <?=$grupo?>,  <?=$turno['turno'] ?></h4>
    <form method="post">
        <div class="form-group">
            <label for="anotacionTextArea">Escribe aquí tus anotaciones</label>
            <textarea class="form-control" id="anotacionTextArea" name="anotacion" rows="3"></textarea>
        </div>

        <button class="btn-b aqua-gradient btn-block p-3" type="submit" name="subir">Subir</button><br>
        <button class="btn btn-block p-3" type="submit" name="regresar">Regresar</button><br>
    </form>
    <?php endif; ?>
</div>
