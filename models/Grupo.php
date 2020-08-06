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
            JOIN Turno t on t.idTurno = grup.idTurno 
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

    // @method  SELECT
    // @desc    GET id de grupo
    // @params  idEscuela, turno tipo, grado, grupo
    public function getGrupoId($idEscuela, $tipoTurno, $grupo) {
      $sql = 'SELECT idGrupo
      FROM Grupo grup 
      JOIN Turno t on t.idTurno = grup.idTurno 
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
    public function groupExists($grupo, $descTurno, $escuela, $asesor) {
      $sql = "SELECT 
          e.nombre AS Escuela, 
          gu.grupo AS Grupo, 
          gu.idGrupo AS idGrupo, 
          ase.nombre AS NAsesor, 
          t.descripcion AS Turno
        FROM Grupo as gu 
        JOIN Turno as t ON gu.idTurno = t.idTurno
        JOIN Escuela as e ON t.idEscuela = e.idEscuela
        JOIN Localidad as l ON l.idLocalidad = e.idLocalidad
        JOIN Asesor as ase ON t.idAsesor = ase.idAsesor
        WHERE gu.grupo = :grupo 
        AND t.descripcion = :descTurno
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
   
    public function addGrupo($descripcion,$grado){
        $query = 'INSERT INTO Grupo (idGrupo, grupo, idGrado) '
                . 'VALUES (null, :desGrupo, :idGrado)';
        
        $this->db->query($query);
        
        $this->db->bind('desGrupo', $descripcion);
        $this->db->bind(':idGrado', $grado);
        
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
    
    public function updateGrado($idGrado,$idGrupo){
        $query = 'UPDATE Grupo
	SET idGrado = :idGrado
	WHERE idGrupo = :idGrupo';
        
        $this->db->query($query);
        
        $this->db->bind(':idGrado', $idGrado);
        $this->db->bind(':idGrupo', $idGrupo);
        
        
        if ($this->db->execute()) {
            return true;
        }
        return false;
    }
    
    public function deleteGrupo($idGrupo){
        $query = 'DELETE * FROM Grupo
	WHERE idGrupo = :idGrupo';
        
        $this->db->query($query);
        
        $this->db->bind(':idGrado', $idGrado);
        
        
        if ($this->db->execute()) {
            return true;
        }
        return false;
    }
    
    public function getGroupById($idGrupo){
        $query = 'SELECT * FROM grupo WHERE idGrupo = :idGrupo';
        
        $this->db->query($query);
        
        $this->db->bind(':idGrupo', $idGrupo);
        
        return $this->db->resultSet();
    }
    
  }