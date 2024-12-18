<?php
/*
 * MySQLi Database Class
 * Connect to database
 * Create prepared statements
 * Bind Values
 * Return results
 */
class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $mysqli;
    private $stmt;
    private $error;

    public function __construct(){
        // Create MySQLi connection
        $this->mysqli = new mysqli($this->host, $this->user, $this->pass, $this->dbname);

        // Check connection
        if($this->mysqli->connect_error){
            $this->error = $this->mysqli->connect_error;
            echo $this->error;
        }
    }

    // Prepare statement with query
    public function query($sql){
        $this->stmt = $this->mysqli->prepare($sql);
        if($this->stmt === false){
            $this->error = $this->mysqli->error;
            echo $this->error;
        }
    }

    // Bind values
    public function bind($param, $value, $type = null){
        if(is_null($type)){
            switch(true){
                case is_int($value):
                    $type = 'i'; // Integer
                    break;
                case is_double($value):
                    $type = 'd'; // Double
                    break;
                case is_string($value):
                    $type = 's'; // String
                    break;
                case is_null($value):
                    $type = 's'; // String (to handle nulls as well)
                    break;
            }
        }

        // Bind parameters
        $this->stmt->bind_param($type, $value);
    }

    // Execute the prepared statement
    public function execute(){
        return $this->stmt->execute();
    }

    // Get result set as array of objects
    public function resultSet(){
        $this->execute();
        $result = $this->stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Get single record as an object
    public function single(){
        $this->execute();
        $result = $this->stmt->get_result();
        return $result->fetch_assoc();
    }

    // Get row count
    public function rowCount(){
        $result = $this->stmt->get_result();
        return $result->num_rows;
    }
}
?>
