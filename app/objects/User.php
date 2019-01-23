<?php

// 'User' object
class User{

    // database connection and table name
    private $conn;
    private $table_name = "users";

    // object properties
    public $id;
    public $firstname;
    public $lastname;
    public $email;
    public $contact_number;
    public $address;
    public $password;
    public $access_level;
    public $access_code;
    public $status;
    public $created;
    public $modified;

    // constructor
    public function __construct($db){
        $this->conn = $db;
    }

    //Checking if email exists method
    function emailExists(){

        // query to check if email exists
        /* In PHP when we are using variables like: $This-table_Name, Table_name is set  ahead and because
        we are using $ on "This" we dont need to write $table_name*/

        $query = "SELECT id, first_name, last_name, access_level, password, status
            FROM " . $this->table_name . "
            WHERE email = ?
            LIMIT 0,1";

        // prepare the query
        $stmt = $this->conn->prepare( $query );

        // sanitize
        $this->email=htmlspecialchars(strip_tags($this->email));

        // bind given email value
        $stmt->bindParam(1, $this->email);

        // execute the query
        $stmt->execute();

        // get number of rows
        $num = $stmt->rowCount();

        // if email exists, assign values to object properties for easy access and use for php sessions
        if($num>0){

            // get record details / values
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // assign values to object properties
            $this->id = $row['id'];
            $this->firstname = $row['first_name'];
            $this->lastname = $row['last_name'];
            $this->access_level = $row['access_level'];
            $this->password = $row['password'];
            $this->status = $row['status'];

            // return true because email exists in the database
            return true;
        }

        // return false if email does not exist in the database
        return false;
    }

    // create new user record
    function create(){

        // to get time stamp for 'created' field
        $this->created=date('Y-m-d H:i:s');

        // insert query
        $query = "INSERT INTO
                " . $this->table_name . "
            SET
                first_name = :firstname,
                last_name = :lastname,
                email = :email,
                contact_number = :contact_number,
                address = :address,
                password = :password,
                access_level = :access_level,
                status = :status,
                created = :created";

        // prepare the query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->firstname=htmlspecialchars(strip_tags($this->firstname));
        $this->lastname=htmlspecialchars(strip_tags($this->lastname));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->contact_number=htmlspecialchars(strip_tags($this->contact_number));
        $this->address=htmlspecialchars(strip_tags($this->address));
        $this->password=htmlspecialchars(strip_tags($this->password));
        $this->access_level=htmlspecialchars(strip_tags($this->access_level));
        $this->status=htmlspecialchars(strip_tags($this->status));

        // bind the values
        $stmt->bindParam(':firstname', $this->firstname);
        $stmt->bindParam(':lastname', $this->lastname);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':contact_number', $this->contact_number);
        $stmt->bindParam(':address', $this->address);

        // hash the password before saving to database
        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $password_hash);

        $stmt->bindParam(':access_level', $this->access_level);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':created', $this->created);

        // execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }else{
            $this->showError($stmt);
            return false;
        }

    }
//     id = :id"
    function Update(){
        // update query
        $query = "UPDATE
                " . $this->table_name . "
            SET
                first_name = :firstname,
                last_name = :lastname,
                email = :email,
                contact_number = :contact_number,
                address = :address,
                password = :password 
            WHERE
                id = $this->id";
      
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->firstname=htmlspecialchars(strip_tags($this->firstname));
        $this->lastname=htmlspecialchars(strip_tags($this->lastname));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->contact_number=htmlspecialchars(strip_tags($this->contact_number));
        $this->address=htmlspecialchars(strip_tags($this->address));
        $this->password=htmlspecialchars(strip_tags($this->password));

        // bind new values
        $stmt->bindParam(':first_name', $this->firstname);
        $stmt->bindParam(':last_name', $this->lastname);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':contact_number', $this->contact_number);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':password', $this->password);

        // execute the query
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    // read all user records
    function readAll($from_record_num, $records_per_page){

        // query to read all user records, with limit clause for pagination
        $query = "SELECT
                `id`,
                `first_name`,
                `last_name`,
                email,
                contact_number,
                access_level,
                created
            FROM " . $this->table_name . "
            ORDER BY id DESC
            LIMIT ?, ?";

        // prepare query statement
        $stmt = $this->conn->prepare( $query );

        // bind limit clause variables
        $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);

        // execute query
        $stmt->execute();

        // return values
        return $stmt;
    }

    // used for paging users
    public function countAll(){

        // query to select all user records
        $query = "SELECT id FROM " . $this->table_name . "";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        // get number of rows
        $num = $stmt->rowCount();

        // return row count
        return $num;
    }

//    function read(){
//
//        // select all query
//        $query = "SELECT `id`,
//                `first_name`,
//                `last_name`,
//                email,
//                contact_number,
//                access_level
//            FROM
//                " . $this->table_name . "WHERE
//                id = $this->user_id
//            LIMIT
//                0,1";
//
//        // prepare query statement
//        $stmt = $this->conn->prepare($query);
//
//        // execute query
//        $stmt->execute();
//
//        return $stmt;
//    }


    public function showError($stmt){
        echo "<pre>";
        print_r($stmt->errorInfo());
        echo "</pre>";
    }

}