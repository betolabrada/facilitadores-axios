<?php

  class Grupo {
    private $db;

    public function __construct() {
      $this->db = new Database();
    }

    // Get information about student group
    public function getInfoGrupo($idEscuela, $descTurno, $grupo) {
      $sql = 'SELECT 
            grup.grupo
            , a.nombre
            , e.nombre as nombreEscuela
            , t.tipo
            , e.numero
            , l.nombre as sede
          FROM Grupo grup 
            JOIN Turno t on t.idTurno = grup.idTurno 
            JOIN Asesor a on a.idAsesor = t.idAsesor 
            JOIN Escuela e on e.idEscuela = t.idEscuela
            JOIN Localidad l on l.idLocalidad = e.idLocalidad
          WHERE e.idEscuela = :idEscuela
          AND grup.grupo = :grupo ' ;
      
      $this->db->query($sql);

      // Bind params
      $this->db->bind(':idEscuela', $idEscuela);
      $this->db->bind(':descTurno', $descTurno);
      $this->db->bind(':grupo', $grupo);

      // Get result
      return $this->db->single();
    }

    // @method  SELECT
    // @desc    GET id de grupo
    // @params  idEscuela, turno tipo, grupo
    public function getGrupoId($idEscuela, $tipoTurno, $grupo) {
      $sql = 'SELECT idGrupo
      FROM Grupo grup 
      JOIN Turno t on t.idTurno = grup.idTurno 
      JOIN Asesor a on a.idAsesor = t.idAsesor 
      JOIN Escuela e on e.idEscuela = t.idEscuela
      WHERE e.idEscuela = :idEscuela
      AND t.tipo = :tipoTurno
      AND grup.grupo = :grupo';

      $this->db->query($sql);

      $this->db->bind(':idEscuela', $idEscuela);
      $this->db->bind(':tipoTurno', $tipoTurno);
      $this->db->bind(':grupo', $grupo);

      if ($row = $this->db->single()) {
        return $row['idGrupo'];
      } else {
        return null;
      }

    }

    // @method  SELECT
    // @desc    GET ALUMNOS de Grupo
    // @fields  noLista, nombre, apellido 
    public function getAlumnos($grupoId) {
      $query = "SELECT noLista, idAlumno, nombre, apellido FROM Alumno WHERE idGrupo = :grupoId";

      $this->db->query($query);

      $this->db->bind(':grupoId', $grupoId);

      return $this->db->resultSet();
    }

    // Valida que el grupo existe
    public function groupExists($grupo, $descTurno, $escuela, $asesor) {
      $sql = "SELECT 
          e.nombre AS Escuela, 
          gu.grupo AS Grupo, 
          gu.idGrupo AS idGrupo, 
          ase.nombre AS NAsesor, 
          t.tipo AS Turno
        FROM Grupo as gu 
        JOIN Turno as t ON gu.idTurno = t.idTurno
        JOIN Escuela as e ON t.idEscuela = e.idEscuela
        JOIN Localidad as l ON l.idLocalidad = e.idLocalidad
        JOIN Asesor as ase ON t.idAsesor = ase.idAsesor
        WHERE gu.grupo = :grupo 
        AND e.idEscuela = :escuela  
        AND ase.nombre = :asesor";

      $this->db->query($sql);

      $this->db->bind(':grupo', $grupo);
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
   
    public function addGrupo($grupo, $idTurno) {
        $query = 'INSERT INTO Grupo (idGrupo, grupo, idTurno) VALUES (null, :grupo, :idTurno)';
        
        $this->db->query($query);
        
        $this->db->bind('grupo', $grupo);
        $this->db->bind(':idTurno', $turno);
        
        if ($this->db->execute()) {
            return true;
        }
        return false;
    }
    
    public function editarGrupo($variable,$variableCambiar,$idGrupo){
        $query = 'UPDATE Grupo
          SET :variable = :variableCambiar
          WHERE idGrupo = :idGrupo';
        
        $this->db->query($query);
        
        $this->db->bind(':variable', $variable);
        $this->db->bind(':variableCambiar', $variableCambiar);
        $this->db->bind(':idGrupo', $idGrupo);
        
        
        if ($this->db->execute()) {
            return true;
        }
        return false;
    }
    
    
    public function deleteGrupo($idGrupo){
        $query = 'DELETE FROM Grupo WHERE idGrupo = :idGrupo';
        
        $this->db->query($query);
        
        $this->db->bind(':idGrupo', $idGrupo);
        
        
        if ($this->db->execute()) {
            return true;
        }
        return false;
    }
    
    public function getGrupoById($idGrupo){
        $query = 'SELECT * FROM Grupo WHERE idGrupo = :idGrupo';
        
        $this->db->query($query);
        
        $this->db->bind(':idGrupo', $idGrupo);
        
        return $this->db->resultSet();
    }

    // @method  SELECT
    // @desc    GET Grupo por su 'grupo' y su $idTurno. Ej. getGrupo('1A', 3)
    public function getGrupo($grupo, $idTurno) {
      $query = "SELECT * FROM Grupo WHERE grupo = :grupo AND idTurno = :idTurno";

      $this->db->query($query);

      $this->db->bind(':grupo', $grupo);
      $this->db->bind(':idTurno', $idTurno);

      return $this->db->single();
    }

    // @method  SELECT
    // @desc    GET Escuela,Turno dado idGrupo Ej. Mixta #5 "Lic. Juan Manuel Ruvalcaba De la Mora",M
    public function getTurnoByIdGrupo($idGrupo) {
      $query = "SELECT CONCAT(Escuela.nombre, ',', Turno.tipo) AS turno 
        FROM Grupo 
          JOIN Turno on Turno.idTurno = Grupo.idTurno 
          JOIN Escuela on Escuela.idEscuela = Turno.idEscuela 
        WHERE idGrupo = :idGrupo";

      $this->db->query($query);

      $this->db->bind(':idGrupo', $idGrupo);

      $record = $this->db->single();
      if ($record) {
        return $record['turno'];
      } else {
        return 'N/A';
      }
    }
  }