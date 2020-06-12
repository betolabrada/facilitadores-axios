<?php
  include '../config/Conn.php';

  function getNombreEscuela($idEscuela) {
      $sql = "SELECT nombre FROM Escuela WHERE idEscuela = $idEscuela";
      $result = $GLOBALS['conn']->query($sql) or die($GLOBALS['conn']->error);
      return $result->fetch_assoc()['nombre'];
  }

  function getDatos($pEscuela, $pTurno, $pGrado, $pGrupo) {
    $sql = "SELECT 
          grup.grupo
          , a.nombre
          , e.nombre as nombreEscuela
          , t.tipo
          , t.descripcion
          , e.numero
          , l.nombre as sede
        FROM Grupo grup 
          JOIN Grado grad on grad.idGrado = grup.idGrado 
          JOIN Turno t on t.idTurno = grad.idTurno 
          JOIN Asesor a on a.idAsesor = t.idAsesor 
          JOIN Escuela e on e.idEscuela = t.idEscuela
          JOIN Localidad l on l.idLocalidad = e.idLocalidad
        WHERE e.idEscuela = '$pEscuela'
        AND t.descripcion = '$pTurno'
        AND grad.numero = '$pGrado'
        AND grup.grupo LIKE '_$pGrupo%' " ;
    
    $result = $GLOBALS['conn']->query($sql) or die($GLOBALS['conn']->error);
    return $result;
  }

  function getGrupoId($pEscuela, $pTurno, $pGrado, $pGrupo) {
    $conn = $GLOBALS['conn'];

    $sql = "SELECT grupo.idGrupo 
      from grupo 
      JOIN grado on grupo.idGrado = grado.idGrado 
      JOIN turno on grado.idTurno = turno.idTurno 
      JOIN escuela on turno.idEscuela = escuela.idEscuela 
      WHERE escuela.idEscuela = '$pEscuela'
      AND turno.descripcion = '$pTurno' 
      AND grado.numero = '$pGrado' 
      AND grupo.grupo LIKE '_$pGrupo%'";
        
    $result = $conn->query($sql) or die($conn->error);

    if ($result->num_rows == 0) {
      return 0;
    }

    return $result->fetch_row()[0];
  }

  function getAlumnos($grupoId) {

    $conn = $GLOBALS['conn'];

    $sql = "SELECT * FROM Alumno WHERE idGrupo = " . $grupoId . " ORDER BY idAlumno";
    $result = $conn->query($sql) or die($conn->error);

    return $result;

  }

  // Escuelas
  $escuelas = $conn->query("SELECT idEscuela, nombre FROM Escuela");

  // Datos de busqueda
  $busqueda = false;
  $datos = null;

  // Alumnos
  $resultAlumnosSuccess = false;
  
  if (isset($_GET['search'])) {
    $busqueda = true;
    if (!$_GET['escuela'] || !$_GET['turno'] || !$_GET['grado'] || !$_GET['grupo'] ) {
      $_SESSION['message'] = "Error. Por favor completa todos los campos.";
      $badRequest = true;
    } else {
      $pEscuela = $_GET['escuela'];
      $pTurno = $_GET['turno'] == 1 ? "Matutino" : "Vespertino";
      $pGrado = $_GET['grado'];
      $pGrupo = $_GET['grupo'];
      $datos = getDatos($pEscuela, $pTurno, $pGrado, $pGrupo);
      $grupoId = getGrupoId($pEscuela,$pTurno, $pGrado, $pGrupo);
      $alumnos = getAlumnos($grupoId);
      if ($alumnos->num_rows > 0) {
        $resultAlumnosSuccess = true;
      }
    }
  }

  
?>