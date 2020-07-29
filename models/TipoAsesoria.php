<?php

    class Escuela {
        private $db;

        public function __construct() {
          $this->db = new Database();
        }
        
        public function addTipoAsesoria($tipoAsesoria){
            $query = 'INSERT INTO TipoAsesoria (idTipoAsesoria, tipoAsesoria) '
                    . 'VALUES (null, :textoAsesoria)';
        
            $this->db->query($query);

            $this->db->bind(':textoAsesoria', $tipoAsesoria);

            if ($this->db->execute()) {
                return true;
            }
            return false;
        }
        
        public function deleteTipoAsesoria($idAsesoria){
            $query = 'DELETE FROM TipoAsesoria '
                    . 'WHERE idTipoAsesoria = :idTipoAsesoria';
        
            $this->db->query($query);

            $this->db->bind(':idTipoAsesoria', $idAsesoria);

            if ($this->db->execute()) {
                return true;
            }
            return false;
        }
    
    }