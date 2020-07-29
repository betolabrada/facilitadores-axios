<?php 
include 'navbar_admin.php'; 
$idEscuela = (int)$_POST['id'];

require_once '../models/Escuela.php';
require_once '../models/Sede.php';


$escuela_model = new Escuela;
$sede_model = new Sede;

$escuela = $escuela_model->getEscuela($idEscuela);
$sedes = $sede_model->getSedes();

$sede = 'No encontrada';

for($index = 0;$index < count($sedes);$index++) {
    if($sedes[$index]['idLocalidad']==$escuela['idLocalidad']){
        $sede = $sedes[$index]['nombre'];
        break;
    }
}
    
?>

<div class="container">
  <h3 class="display-3 text-center">Datos de la Asesoria</h3>
  <br>
    <div class="row my-4">
        <div class="col-sm-2"></div>
          <div class="col-sm-8">           
            <h5 class="display-5 text-center">Nombre: <?php echo $escuela['nombre']?></h5>
            <h5 class="display-5 text-center">Numero: <?php echo $escuela['numero']?></h5>
            <h5 class="display-5 text-center">Turno: <?php echo $escuela['turno']?></h5>
            <h5 class="display-5 text-center">Localidad: <?php echo $sede ?></h5>
          </div>
        </div>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <form action="borrar_escuela.php" method="POST" id="confirmarForm">
                <input type="number" name="id" value="<?php echo $idEscuela?>" hidden="hidden"/>
            </form>
            <form action="../admin_dashboard.php" method="POST" id="cancelarForm">
            </form>
            <div class="row my-4 justify-content-center">
              <div class="col-sm-3">
                <button class="btn btn-danger btn-lg btn-primary btn-block text-uppercase" name="subir" form="confirmarForm">Borrar</button>
              </div>
              <div class="col-sm-3">
                <button class="btn btn-success btn-lg btn-primary btn-block text-uppercase" name="cancelar" form="cancelarForm">Cancelar</button>
              </div>
            </div>
        </div>
    </div>
</body>
</html>