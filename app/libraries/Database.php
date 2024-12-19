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

    private $dbh;
    private $stmt;
    private $error;

    public function __construct(){
        // Create database connection
        $this->dbh = new mysqli($this->host, $this->user, $this->pass, $this->dbname);

        if ($this->dbh->connect_error) {
            die("Connection failed: " . $this->dbh->connect_error);
        }
    }

    // Prepare query
    public function query($sql){
        $this->stmt = $this->dbh->prepare($sql);
        if (!$this->stmt) {
            die("Query preparation error: " . $this->dbh->error . "\nSQL: " . $sql);
        }
    }

    // Bind values dynamically
    public function bind($types, ...$values){
        $this->stmt->bind_param($types, ...$values);
    }

    // Execute statement
    public function execute(){
        return $this->stmt->execute();
    }

    // Fetch single result
    public function single(){
        $this->stmt->execute();
        $result = $this->stmt->get_result();
        return $result->fetch_object();
    }

    // Fetch multiple results
    public function results(){
        $this->stmt->execute();
        $result = $this->stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Get row count
    public function rowCount(){
        $this->stmt->store_result();
        return $this->stmt->num_rows;
    }
}
?>
