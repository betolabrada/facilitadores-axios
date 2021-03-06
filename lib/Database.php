<?php
// instance of db
class Database {
    private $conn;
    private $stmt;

    private $servername = DB_HOST;
		private $username = DB_USER;
		private $password = DB_PASS;
		private $database = DB_NAME;

    public function __construct() {
        // Set DSN
		$dsn = 'mysql:host=' . $this->servername . ';dbname=' . $this->database;
		$options = array (
			PDO::ATTR_PERSISTENT => true,
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION 
		);
		// Create a new PDO instanace
		try {
			$this->conn = new PDO ($dsn, $this->username, $this->password, $options);
		}		// Catch any errors
		catch ( PDOException $e ) {
			$this->error = $e->getMessage();
		}
    }

    // Preparar query
    public function query($query) {
        $this->stmt = $this->conn->prepare($query);
    }

    // Bind values
	public function bind($param, $value, $type = null) {
		if (is_null ($type)) {
			switch (true) {
				case is_int ($value) :
					$type = PDO::PARAM_INT;
					break;
				case is_bool ($value) :
					$type = PDO::PARAM_BOOL;
					break;
				case is_null ($value) :
					$type = PDO::PARAM_NULL;
					break;
				default :
					$type = PDO::PARAM_STR;
			}
		}
		$this->stmt->bindValue($param, $value, $type);
	}

  // Execute the prepared statement
	public function execute(){
		return $this->stmt->execute();
    }

    // Get result set as associative array
	public function resultSet(){
		$this->execute();
		return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Get single record as object
	public function single(){
		$this->execute();
		return $this->stmt->fetch(PDO::FETCH_ASSOC);
	}
	
	// Get record row count
	public function rowCount(){
		return $this->stmt->rowCount();
	}
}