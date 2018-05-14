<?php
class Owner{
 
    // database connection and table name
    private $conn;
    private $table_name = "owners";

    // object properties
    public $idOwner;
    public $idProperty;
    public $idCoproperty;
    public $enabled;
    public $idPerson;
    public $living;
    public $suscriptionDate;
    public $customParams = [];

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // used when log to choose with which copro and role the person will follow his session
    function readByIdPerson(){
        
        // select all query 
        $query = "SELECT o.idOwner, o.idProperty, p.idCoproperty, o.enabled, o.living, o.suscriptionDate 
                    from " . $this->table_name . " o inner join properties p on o.idProperty=p.idProperty
                    where o.idPerson=:idPerson";
    
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
                    idProperty=:idProperty, idPerson=:idPerson, living=:living, suscriptionDate=:suscriptionDate,
                    enabled=:enabled";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->idProperty=htmlspecialchars(strip_tags($this->idProperty));
        $this->idPerson=htmlspecialchars(strip_tags($this->idPerson));
        $this->living=htmlspecialchars(strip_tags($this->living));
        $this->suscriptionDate=htmlspecialchars(strip_tags($this->suscriptionDate));
        $this->enabled=htmlspecialchars(strip_tags($this->enabled));

        // bind values
        $stmt->bindParam(":idProperty", $this->idProperty);
        $stmt->bindParam(":idPerson", $this->idPerson);
        $stmt->bindParam(":living", $this->living);
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
                living=:living, suscriptionDate=:suscriptionDate, enabled=:enabled
                WHERE
                    idOwner = :idOwner";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->idProperty=htmlspecialchars(strip_tags($this->idProperty));
        $this->idPerson=htmlspecialchars(strip_tags($this->idPerson));
        $this->living=htmlspecialchars(strip_tags($this->living));
        $this->suscriptionDate=htmlspecialchars(strip_tags($this->suscriptionDate));
        $this->enabled=htmlspecialchars(strip_tags($this->enabled));
        $this->idOwner=htmlspecialchars(strip_tags($this->idOwner));
    
        // bind values
        $stmt->bindParam(":idProperty", $this->idProperty);
        $stmt->bindParam(":idPerson", $this->idPerson);
        $stmt->bindParam(":living", $this->living);
        $stmt->bindParam(":suscriptionDate", $this->suscriptionDate);
        $stmt->bindParam(":enabled", $this->enabled);
        $stmt->bindParam(":idOwner", $this->idOwner);
    
        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    // delete the owner rol
    function delete(){
        
        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE idOwner = ?";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->idOwner=htmlspecialchars(strip_tags($this->idOwner));
    
        // bind idOwner of record to delete
        $stmt->bindParam(1, $this->idOwner);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
            
    }

    // return number of owners in the copro
    function countByIdCopro(){
        // select count query 
        $query = "SELECT count(o.idOwner) as number from " . $this->table_name . " o inner join properties p on o.idProperty=p.idProperty
                    where o.enabled=1 and p.idCoproperty=:idCoproperty";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind values
        $stmt->bindParam(":idCoproperty", $this->idCoproperty);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // return number of living owners in the copro
    function livingCountByIdCopro(){
        // select count query 
        $query = "SELECT count(o.idOwner) as number from " . $this->table_name . " o inner join properties p on o.idProperty=p.idProperty
                    where o.enabled=1 and living=1 and p.idCoproperty=:idCoproperty";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind values
        $stmt->bindParam(":idCoproperty", $this->idCoproperty);

        // execute query
        $stmt->execute();

        return $stmt;
    }
}