<?php
class Coproperty{
 
    // database connection and table name
    private $conn;
    private $table_name = "coproperties";
 
    // object properties
    public $idCoproperty;
    public $identification;
    public $address;
    public $latitud;
    public $longitud;
    public $suscriptionDate;
    public $lastUpdate;
    public $enabled;
    public $stringData = array();
    public $numericData = array();
    public $timeData = array();
    public $fileData = array();

 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read copropertys
    function read(){    
        // select all query
        $query = "SELECT
                    c.idCoproperty, c.identification, c.address, c.latitud, c.longitud,
                    c.suscriptionDate, c.lastUpdate, c.enabled
                FROM
                    " . $this->table_name . " c
                
                ORDER BY
                    c.suscriptionDate DESC";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

    // used when filling up the update coproperty form
    function readOne(){
    
       // query to read single record
       $query = "SELECT
                   c.idCoproperty, c.identification, c.address, c.latitud, c.longitud,
                   c.suscriptionDate, c.lastUpdate, c.enabled
               FROM
                   " . $this->table_name . " c
               WHERE
                   c.idCoproperty = ?
               LIMIT
                   0,1";
    
       // prepare query statement
       $stmt = $this->conn->prepare( $query );
    
       // bind id of coproperty to be updated
       $stmt->bindParam(1, $this->id);
    
       // execute query
       $stmt->execute();
    
       // get retrieved row
       $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
       // set values to object properties
       $this->identification = $row['identification'];
       $this->address = $row['address'];
       $this->latitud = $row['latitud'];
       $this->longitud = $row['longitud'];
       $this->suscriptionDate = $row['suscriptionDate'];
       $this->lastUpdate = $row['lastUpdate'];
       $this->enabled = $row['enabled'];
    }
    
    // create coproperty
    function create(){
        
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    identification=:identification, address=:address, latitud=:latitud, longitud=:longitud 
                    suscriptionDate=:suscriptionDate, lastUpdate=:lastUpdate, enabled=:enabled";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->identification=htmlspecialchars(strip_tags($this->identification));
        $this->address=htmlspecialchars(strip_tags($this->address));
        $this->latitud=htmlspecialchars(strip_tags($this->latitud));
        $this->longitud=htmlspecialchars(strip_tags($this->longitud));
        $this->suscriptionDate=htmlspecialchars(strip_tags($this->suscriptionDate));
        $this->lastUpdate=htmlspecialchars(strip_tags($this->lastUpdate));
        $this->enabled=htmlspecialchars(strip_tags($this->enabled));
    
        // bind values
        $stmt->bindParam(":identification", $this->identification);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":latitud", $this->latitud);
        $stmt->bindParam(":longitud", $this->longitud);
        $stmt->bindParam(":suscriptionDate", $this->suscriptionDate);
        $stmt->bindParam(":lastUpdate", $this->lastUpdate);
        $stmt->bindParam(":enabled", $this->enabled);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }

    // update the coproperty
    function update(){
    
       // update query
       $query = "UPDATE
                   " . $this->table_name . "
               SET
               identification=:identification, address=:address, 
               latitud=:latitud, longitud=:longitud, suscriptionDate=:suscriptionDate, 
               lastUpdate=:lastUpdate, enabled=:enabled
               WHERE
                   idCoproperty = :idCoproperty";
    
       // prepare query statement
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       $this->identification=htmlspecialchars(strip_tags($this->identification));
       $this->address=htmlspecialchars(strip_tags($this->address));
       $this->latitud=htmlspecialchars(strip_tags($this->latitud));
       $this->longitud=htmlspecialchars(strip_tags($this->longitud));
       $this->suscriptionDate=htmlspecialchars(strip_tags($this->suscriptionDate));
       $this->lastUpdate=htmlspecialchars(strip_tags($this->lastUpdate));
       $this->enabled=htmlspecialchars(strip_tags($this->enabled));
   
       // bind values
       $stmt->bindParam(":identification", $this->identification);
       $stmt->bindParam(":address", $this->address);
       $stmt->bindParam(":latitud", $this->latitud);
       $stmt->bindParam(":longitud", $this->longitud);
       $stmt->bindParam(":suscriptionDate", $this->suscriptionDate);
       $stmt->bindParam(":lastUpdate", $this->lastUpdate);
       $stmt->bindParam(":enabled", $this->enabled);
    
       // execute the query
       if($stmt->execute()){
           return true;
       }
    
       return false;
   }

   // delete the product
    function delete(){
    
       // delete query
       $query = "DELETE FROM " . $this->table_name . " WHERE idCoproperty = ?";
    
       // prepare query
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       $this->id=htmlspecialchars(strip_tags($this->id));
    
       // bind id of record to delete
       $stmt->bindParam(1, $this->id);
    
       // execute query
       if($stmt->execute()){
           return true;
       }
    
       return false;
        
   }
}
?>