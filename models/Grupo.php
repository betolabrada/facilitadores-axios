<?php

  class Grupo {
    private $db;

    public function __construct() {
      $this->db = new Database();
    }

    // Get information about student group
    public function getInfoGrupo($idEscuela, $descTurno, $numGrado, $grupo) {
      $sql = 'SELECT 
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
          WHERE e.idEscuela = :idEscuela
          AND t.descripcion = :descTurno
          AND grad.numero = :numGrado
          AND grup.grupo = :grupo ' ;
      
      $this->db->query($sql);

      // Bind params
      $this->db->bind(':idEscuela', $idEscuela);
      $this->db->bind(':descTurno', $descTurno);
      $this->db->bind(':numGrado', $numGrado);
      $this->db->bind(':grupo', $grupo);

      // Get result
      return $this->db->single();
    }

    // Get grado Id
    public function getGradoId($pEscuela, $pTurno, $pGrado) {
      $sql = 'SELECT idGrado FROM Grado
          JOIN Turno ON Grado.idTurno = Turno.idTurno
          JOIN Escuela ON Turno.idEscuela = Escuela.idEscuela
          WHERE Grado.numero = :numGrado
          AND Turno.descripcion = :descTurno
          AND Escuela.idEscuela = :idEscuela';

      // Prepare query
      $this->db->query($sql);

      // Bind params
      $this->db->bind(':numGrado', $numGrado);
      $this->db->bind(':descTurno', $descTurno);
      $this->db->bind(':idEscuela', $idEscuela);

      // Execute
      $res = $this->db->single();

      return $res['idGrado'];
    }

    // Grupo ID
    public function getGrupoId($idEscuela, $tipoTurno, $grado, $grupo) {
      $sql = 'SELECT idGrupo
      FROM Grupo grup 
      JOIN Grado grad on grad.idGrado = grup.idGrado 
      JOIN Turno t on t.idTurno = grad.idTurno 
      JOIN Asesor a on a.idAsesor = t.idAsesor 
      JOIN Escuela e on e.idEscuela = t.idEscuela
      WHERE e.idEscuela = :idEscuela
      AND t.tipo = :tipoTurno
      AND grad.numero = :grado
      AND grup.grupo = :grupo';

      $this->db->query($sql);

      $this->db->bind(':idEscuela', $idEscuela);
      $this->db->bind(':tipoTurno', $tipoTurno);
      $this->db->bind(':grado', $grado);
      $this->db->bind(':grupo', $grupo);

      if ($row = $this->db->single()) {
        print_r($row);
        return $row['idGrupo'];
      } else {
        return null;
      }

    }

    // @method  SELECT
    // @desc    GET ALUMNOS de Grupo
    // @fields  noLista, nombre, apellido 
    public function getAlumnos($grupoId) {
      $query = "SELECT noLista, nombre, apellido FROM Alumno WHERE idGrupo = :grupoId";

      $this->db->query($query);

      $this->db->bind(':grupoId', $grupoId);

      return $this->db->resultSet();
    }

    // Valida que el grupo existe
    public function groupExists($grupo, $grado, $descTurno, $escuela, $asesor) {
      $sql = "SELECT 
          e.nombre AS Escuela, 
          ga.numero AS Grado,
          gu.grupo AS Grupo, 
          gu.idGrupo AS idGrupo, 
          ase.nombre AS NAsesor, 
          t.descripcion AS Turno
        FROM Grupo as gu 
        JOIN Grado as ga ON gu.idGrado = ga.idGrado
        JOIN Turno as t ON ga.idTurno = t.idTurno
        JOIN Escuela as e ON t.idEscuela = e.idEscuela
        JOIN Localidad as l ON l.idLocalidad = e.idLocalidad
        JOIN Asesor as ase ON t.idAsesor = ase.idAsesor
        WHERE gu.grupo = :grupo 
        AND ga.numero = :grado 
        AND t.descripcion = :descTurno
        AND e.idEscuela = :escuela  
        AND ase.nombre = :asesor";

      $this->db->query($sql);

      $this->db->bind(':grupo', $grupo);
      $this->db->bind(':grado', $grado);
      $this->db->bind(':descTurno', $descTurno);
      $this->db->bind(':escuela', $escuela);
      $this->db->bind(':asesor', $asesor);

      $row = $this->db->single();

      if ($row) {
        return true;
      } else {
        return false;
      }
    }
  }