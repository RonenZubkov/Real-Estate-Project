<?php
// used to get mysql database connection

class Database{

    // specify your own database credentials
    private $host = "localhost";
    private $db_name = "real estate";
    private $username = "AreZi";
    private $password = "H7c2q5uVZsoP1Wda";
    public $conn;

    // get the database connection
    public function getConnection(){

        $this->conn = null;

        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}