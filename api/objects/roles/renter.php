<?php
class Renter{
 
    // database connection and table name
    private $conn;
    private $table_name = "renters";

    // object properties
    public $idRenter;
    public $idProperty;
    public $enabled;
    public $idPerson;
    public $suscriptionDate;
    public $customParams = [];

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // used when log to choose with which copro and role the person will follow his session
    function readByIdPerson(){
        
        // select all query 
        $query = "SELECT r.idRenter, p.idCoproperty, r.enabled, r.suscriptionDate from " . $this->table_name . " r inner join properties p on r.idProperty=p.idProperty
                    where r.idPerson=:idPerson";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind values
        $stmt->bindParam(":idPerson", $this->idPerson);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

    // create owner rol for a person
    function create(){
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    idProperty=:idProperty, idPerson=:idPerson, suscriptionDate=:suscriptionDate,
                    enabled=:enabled";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->idProperty=htmlspecialchars(strip_tags($this->idProperty));
        $this->idPerson=htmlspecialchars(strip_tags($this->idPerson));
        $this->suscriptionDate=htmlspecialchars(strip_tags($this->suscriptionDate));
        $this->enabled=htmlspecialchars(strip_tags($this->enabled));

        // bind values
        $stmt->bindParam(":idProperty", $this->idProperty);
        $stmt->bindParam(":idPerson", $this->idPerson);
        $stmt->bindParam(":suscriptionDate", $this->suscriptionDate);
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
                idProperty=:idProperty, idPerson=:idPerson,
                suscriptionDate=:suscriptionDate, enabled=:enabled
                WHERE
                    idRenter = :idRenter";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->idProperty=htmlspecialchars(strip_tags($this->idProperty));
        $this->idPerson=htmlspecialchars(strip_tags($this->idPerson));
        $this->suscriptionDate=htmlspecialchars(strip_tags($this->suscriptionDate));
        $this->enabled=htmlspecialchars(strip_tags($this->enabled));
        $this->idRenter=htmlspecialchars(strip_tags($this->idRenter));
    
        // bind values
        $stmt->bindParam(":idProperty", $this->idProperty);
        $stmt->bindParam(":idPerson", $this->idPerson);
        $stmt->bindParam(":suscriptionDate", $this->suscriptionDate);
        $stmt->bindParam(":enabled", $this->enabled);
        $stmt->bindParam(":idRenter", $this->idRenter);
    
        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    // delete the owner rol
    function delete(){
        
        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE idRenter = ?";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->idRenter=htmlspecialchars(strip_tags($this->idRenter));
    
        // bind idRenter of record to delete
        $stmt->bindParam(1, $this->idRenter);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
            
    }

    // return number of renters in the copro
    function countByIdCopro(){
        // select count query 
        $query = "SELECT count(o.idRenter) as number from " . $this->table_name . " o inner join properties p on o.idProperty=p.idProperty
                    where o.enabled=1 and p.idCoproperty=:idCoproperty";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind values
        $stmt->bindParam(":idCoproperty", $this->idCoproperty);

        // execute query
        $stmt->execute();

        return $stmt;
    }
}