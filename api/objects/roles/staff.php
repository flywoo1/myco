<?php
class Staff{
 
    // database connection and table name
    private $conn;
    private $table_name = "staffs";

    // object properties
    public $idStaff;
    public $idTicketScope;
    public $idCoproperty;
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
        $query = "SELECT s.idStaff, s.idCoproperty, s.enabled, s.suscriptionDate from " . $this->table_name . " s
                    where s.idPerson=:idPerson";
    
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
                    idTicketScope:=idTicketScope, idCoproperty=:idCoproperty, idPerson=:idPerson, suscriptionDate=:suscriptionDate,
                    enabled=:enabled";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->idTicketScope=htmlspecialchars(strip_tags($this->idTicketScope));
        $this->idCoproperty=htmlspecialchars(strip_tags($this->idCoproperty));
        $this->idPerson=htmlspecialchars(strip_tags($this->idPerson));
        $this->suscriptionDate=htmlspecialchars(strip_tags($this->suscriptionDate));
        $this->enabled=htmlspecialchars(strip_tags($this->enabled));

        // bind values
        $stmt->bindParam(":idTicketScope", $this->idTicketScope);
        $stmt->bindParam(":idCoproperty", $this->idCoproperty);
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
                idTicketScope:=idTicketScope, idCoproperty=:idCoproperty, idPerson=:idPerson,
                suscriptionDate=:suscriptionDate, enabled=:enabled
                WHERE
                    idStaff = :idStaff";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->idTicketScope=htmlspecialchars(strip_tags($this->idTicketScope));
        $this->idCoproperty=htmlspecialchars(strip_tags($this->idCoproperty));
        $this->idPerson=htmlspecialchars(strip_tags($this->idPerson));
        $this->suscriptionDate=htmlspecialchars(strip_tags($this->suscriptionDate));
        $this->enabled=htmlspecialchars(strip_tags($this->enabled));
        $this->idStaff=htmlspecialchars(strip_tags($this->idStaff));
    
        // bind values
        $stmt->bindParam(":idTicketScope", $this->idTicketScope);
        $stmt->bindParam(":idCoproperty", $this->idCoproperty);
        $stmt->bindParam(":idPerson", $this->idPerson);
        $stmt->bindParam(":suscriptionDate", $this->suscriptionDate);
        $stmt->bindParam(":enabled", $this->enabled);
        $stmt->bindParam(":idStaff", $this->idStaff);
    
        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    // delete the owner rol
    function delete(){
        
        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE idStaff = ?";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->idStaff=htmlspecialchars(strip_tags($this->idStaff));
    
        // bind idStaff of record to delete
        $stmt->bindParam(1, $this->idStaff);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
            
    }
}