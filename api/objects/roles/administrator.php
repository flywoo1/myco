<?php
class Administrator{
 
    // database connection and table name
    private $conn;
    private $table_name = "administrators";

    // object properties
    public $idAdministrator;
    public $idCoproperty;
    public $enabled;
    public $idPerson;
    public $customParams = [];

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // used when log to choose with which copro and role the person will follow his session
    function readByIdPerson(){
        
        // select all query 
        $query = "SELECT a.idAdministrator, a.idCoproperty, a.enabled from " . $this->table_name . " a
                    where a.idPerson=:idPerson";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind values
        $stmt->bindParam(":idPerson", $this->idPerson);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

    function create(){
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    idCoproperty=:idCoproperty, idPerson=:idPerson,
                    enabled=:enabled";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->idCoproperty=htmlspecialchars(strip_tags($this->idCoproperty));
        $this->idPerson=htmlspecialchars(strip_tags($this->idPerson));
        $this->enabled=htmlspecialchars(strip_tags($this->enabled));

        // bind values
        $stmt->bindParam(":idCoproperty", $this->idCoproperty);
        $stmt->bindParam(":idPerson", $this->idPerson);
        $stmt->bindParam(":enabled", $this->enabled);

        // execute query
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    // update the owner rol
    function update(){
        
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                idCoproperty=:idCoproperty, idPerson=:idPerson, enabled=:enabled
                WHERE
                    idAdministrator = :idAdministrator";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->idCoproperty=htmlspecialchars(strip_tags($this->idCoproperty));
        $this->idPerson=htmlspecialchars(strip_tags($this->idPerson));
        $this->enabled=htmlspecialchars(strip_tags($this->enabled));
        $this->idAdministrator=htmlspecialchars(strip_tags($this->idAdministrator));
    
        // bind values
        $stmt->bindParam(":idCoproperty", $this->idCoproperty);
        $stmt->bindParam(":idPerson", $this->idPerson);
        $stmt->bindParam(":enabled", $this->enabled);
        $stmt->bindParam(":idAdministrator", $this->idAdministrator);
    
        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    // delete the owner rol
    function delete(){
        
        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE idAdministrator = ?";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->idAdministrator=htmlspecialchars(strip_tags($this->idAdministrator));
    
        // bind idAdministrator of record to delete
        $stmt->bindParam(1, $this->idAdministrator);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
            
    }
}