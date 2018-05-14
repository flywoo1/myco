<?php
class Person{
 
    // database connection and table name
    private $conn;
    private $table_name = "persons";
 
    // object properties
    public $idPerson;
    public $firstName;
    public $lastName;
    public $phoneNumber;
    public $address;
    public $email;
    public $password;
    public $language;
    public $suscriptionDate;
    public $lastUpdate;
    public $enabled;
    public $roles = [];
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read persons
    function read(){    
        // select all query
        $query = "SELECT
                    p.idPerson, p.firstName, p.lastName, p.phoneNumber, p.address, p.email,
                    p.language, p.suscriptionDate, p.lastUpdate, p.enabled
                FROM
                    " . $this->table_name . " p
                ORDER BY
                    p.suscriptionDate DESC";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

    // used when filling up the update person form
    function readOne(){
    
       // query to read single record
       $query = "SELECT
                   p.idPerson, p.firstName, p.lastName, p.phoneNumber, p.address, p.email,
                   p.password, p.language, p.suscriptionDate, p.lastUpdate, p.enabled
               FROM
                   " . $this->table_name . " p
               WHERE
                   p.idPerson = ?
               LIMIT
                   0,1";
    
       // prepare query statement
       $stmt = $this->conn->prepare( $query );
    
       // bind id of person to be updated
       $stmt->bindParam(1, $this->idPerson);
    
       // execute query
       $stmt->execute();
    
       // get retrieved row
       $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
       // set values to object properties
       $this->firstName = $row['firstName'];
       $this->lastName = $row['lastName'];
       $this->phoneNumber = $row['phoneNumber'];
       $this->address = $row['address'];
       $this->email = $row['email'];
       $this->password = $row['password'];
       $this->language = $row['language'];
       $this->suscriptionDate = $row['suscriptionDate'];
       $this->lastUpdate = $row['lastUpdate'];
       $this->enabled = $row['enabled'];
    }
    
    // create person
    function create(){
        
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    firstName=:firstName, lastName=:lastName, phoneNumber=:phoneNumber, email=:email, address=:address
                    , language=:language, suscriptionDate=:suscriptionDate, lastUpdate=:lastUpdate, enabled=:enabled
                    , password=:password";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->firstName=htmlspecialchars(strip_tags($this->firstName));
        $this->lastName=htmlspecialchars(strip_tags($this->lastName));
        $this->phoneNumber=htmlspecialchars(strip_tags($this->phoneNumber));
        $this->address=htmlspecialchars(strip_tags($this->address));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->language=htmlspecialchars(strip_tags($this->language));
        $this->suscriptionDate=htmlspecialchars(strip_tags($this->suscriptionDate));
        $this->lastUpdate=htmlspecialchars(strip_tags($this->lastUpdate));
        $this->enabled=htmlspecialchars(strip_tags($this->enabled));
        $this->password=htmlspecialchars(strip_tags($this->password));
    
        // bind values
        $stmt->bindParam(":firstName", $this->firstName);
        $stmt->bindParam(":lastName", $this->lastName);
        $stmt->bindParam(":phoneNumber", $this->phoneNumber);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":language", $this->language);
        $stmt->bindParam(":suscriptionDate", $this->suscriptionDate);
        $stmt->bindParam(":lastUpdate", $this->lastUpdate);
        $stmt->bindParam(":enabled", $this->enabled);
        $stmt->bindParam(":password", $this->password);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }

    // update the person
    function update(){
    
       // update query
       $query = "UPDATE
                   " . $this->table_name . "
               SET
               firstName=:firstName, lastName=:lastName, 
               phoneNumber=:phoneNumber, address=:address, email=:email,
               language=:language, 
               lastUpdate=:lastUpdate, enabled=:enabled,
               password=:password
               WHERE
                   idPerson = :idPerson";
    
       // prepare query statement
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       $this->firstName=htmlspecialchars(strip_tags($this->firstName));
       $this->lastName=htmlspecialchars(strip_tags($this->lastName));
       $this->phoneNumber=htmlspecialchars(strip_tags($this->phoneNumber));
       $this->address=htmlspecialchars(strip_tags($this->address));
       $this->email=htmlspecialchars(strip_tags($this->email));
       $this->language=htmlspecialchars(strip_tags($this->language));
       $this->lastUpdate=htmlspecialchars(strip_tags($this->lastUpdate));
       $this->enabled=htmlspecialchars(strip_tags($this->enabled));
       $this->password=htmlspecialchars(strip_tags($this->password));
       $this->idPerson=htmlspecialchars(strip_tags($this->idPerson));
   
       // bind values
       $stmt->bindParam(":firstName", $this->firstName);
       $stmt->bindParam(":lastName", $this->lastName);
       $stmt->bindParam(":phoneNumber", $this->phoneNumber);
       $stmt->bindParam(":address", $this->address);
       $stmt->bindParam(":email", $this->email);
       $stmt->bindParam(":language", $this->language);
       $stmt->bindParam(":lastUpdate", $this->lastUpdate);
       $stmt->bindParam(":enabled", $this->enabled);
       $stmt->bindParam(":password", $this->password);
       $stmt->bindParam(":idPerson", $this->idPerson);
    
       // execute the query
       if($stmt->execute()){
           return true;
       }
    
       return false;
   }

   // delete the person
    function delete(){
    
       // delete query
       $query = "DELETE FROM " . $this->table_name . " WHERE idPerson = ?";
    
       // prepare query
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       $this->idPerson=htmlspecialchars(strip_tags($this->idPerson));
    
       // bind id of record to delete
       $stmt->bindParam(1, $this->idPerson);
    
       // execute query
       if($stmt->execute()){
           return true;
       }
    
       return false;
        
   }
}
?>