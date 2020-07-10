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
      $this->conn->query($sql);

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
  }