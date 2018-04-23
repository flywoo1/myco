<?php
$tableArrayByType = json_decode(file_get_contents('../config/datatablebytype.json')); // the idea is  include json with type and related tables and key
class CustomParam{
 
    // database connection and table name
    private $conn;    

    private $table_conf = "";
    private $key_conf = "";
    private $table_value = "";
    private $key_value = "";
 
    // object properties
    public $id; //id of the entity
    public $id_conf; //id of type by CoproEntity (idTimeDataByCoproEntity)
    public $id_value; //id of type by entityId (idTimeDataByEntityId)
    public $type;
    public $idEntity;
    public $idCoproperty;
    public $label;
    public $value;
    public $enabled;
    public $fieldorder;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // used when filling up the new entity
    function readByCoproEntity(){  
        
        // select all query !!!TODO case for all coproperties idCopro=0
        $query = "SELECT 'time' as type, tbct.idTimeDataByCoproEntity as 'id_conf', tbct.label, tbct.fieldorder, tbct.enabled from timeDataByCoproEntities tbct
                    where tbct.idCoproperty=:idCoproperty and tbct.idEntity=:idEntity
                    Union 
                    SELECT 'string', sbct.idStringDataByCoproEntity, sbct.label, sbct.fieldorder, sbct.enabled from stringdatabycoproentities sbct
                    where sbct.idCoproperty=:idCoproperty and sbct.idEntity=:idEntity
                    Union
                    SELECT 'file', fbct.idFileByCoproEntity, fbct.label, fbct.fieldorder, fbct.enabled from filebycoproentities fbct
                    where fbct.idCoproperty=:idCoproperty and fbct.idEntity=:idEntity
                    Union
                    SELECT 'numeric', nbct.idNumericDataByCoproEntity, nbct.label, nbct.fieldorder, nbct.enabled from numericdatabycoproentities nbct
                    where nbct.idCoproperty=:idCoproperty and nbct.idEntity=:idEntity
                    ORDER BY fieldorder asc";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind values
        $stmt->bindParam(":idCoproperty", $this->idCoproperty);
        $stmt->bindParam(":idEntity", $this->idEntity);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

    // used when filling up the update entity form
    function readByIdEntity(){
    
        // query to read single record !!!TODO case for all coproperties idCopro=0
        $query = "SELECT 'time' as type, tbe.idTimeDataByEntityId as 'id_value', tbct.idTimeDataByCoproEntity as 'id_conf', tbct.label, tbct.fieldorder, tbe.value from timeDataByCoproEntities tbct
                    inner join TimeDataByEntityId tbe on tbct.idTimeDataByCoproEntity = tbe.idTimeDataByCoproEntity
                    where tbct.idCoproperty=:idCoproperty and tbct.idEntity=:idEntity and tbe.id=:id and tbct.enabled=1
                    Union 
                    select 'string', sbe.idStringDataByEntityId, sbct.idStringDataByCoproEntity, sbct.label, sbct.fieldorder, sbe.value from stringdatabycoproentities sbct
                    inner join StringDataByEntityId sbe on sbct.idStringDataByCoproEntity = sbe.idStringDataByCoproEntity
                    where sbct.idCoproperty=:idCoproperty and sbct.idEntity=:idEntity and sbe.id=:id and sbct.enabled=1
                    Union
                    select 'file', fbe.idFileByEntityId, fbct.idFileByCoproEntity, fbct.label, fbct.fieldorder, fbe.value from filebycoproentities fbct
                    inner join fileByEntityId fbe on fbct.idFileByCoproEntity = fbe.idFileByCoproEntity
                    where fbct.idCoproperty=:idCoproperty and fbct.idEntity=:idEntity and fbe.id=:id and fbct.enabled=1
                    Union
                    select 'numeric', nbe.idnumericdataByEntityId, nbct.idNumericDataByCoproEntity, nbct.label, nbct.fieldorder, nbe.value from numericdatabycoproentities nbct
                    inner join numericdataByEntityId nbe on nbct.idnumericdataByCoproEntity = nbe.idnumericdataByCoproEntity
                    where nbct.idCoproperty=:idCoproperty and nbct.idEntity=:idEntity and nbe.id=:id and nbct.enabled=1
                    order by fieldorder";

        // prepare query statement
        $stmt = $this->conn->prepare( $query );

        // bind values
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":idCoproperty", $this->idCoproperty);
        $stmt->bindParam(":idEntity", $this->idEntity);

        // execute query
        $stmt->execute();
        
        return $stmt;
    }
    
    // create new customParam
    function createCustomParam(){
        
        // sanitize
        $this->type=htmlspecialchars(strip_tags($this->type));
        $this->idEntity=htmlspecialchars(strip_tags($this->idEntity));
        $this->idCoproperty=htmlspecialchars(strip_tags($this->idCoproperty));
        $this->label=htmlspecialchars(strip_tags($this->label));
        $this->enabled=htmlspecialchars(strip_tags($this->enabled));
        $this->fieldorder=htmlspecialchars(strip_tags($this->fieldorder));
        
        $this->table_conf=$tableArrayByType.$this->type.$this->table_conf;

        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_conf . "
                SET
                idEntity=:idEntity, idCoproperty=:idCoproperty, label=:label, enabled=:enabled, fieldorder=:fieldorder";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // bind values
        $stmt->bindParam(":idEntity", $this->idEntity);
        $stmt->bindParam(":idCoproperty", $this->idCoproperty);
        $stmt->bindParam(":label", $this->label);
        $stmt->bindParam(":enabled", $this->enabled);
        $stmt->bindParam(":fieldorder", $this->fieldorder);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }

    // update customParam
    function updateCustomParam(){

        // sanitize
        $this->type=htmlspecialchars(strip_tags($this->type));
        $this->label=htmlspecialchars(strip_tags($this->label));
        $this->enabled=htmlspecialchars(strip_tags($this->enabled));
        $this->fieldorder=htmlspecialchars(strip_tags($this->fieldorder));
        $this->id_conf=htmlspecialchars(strip_tags($this->id_conf));
        
        $this->table_conf=$tableArrayByType.$this->type.$this->table_conf;
        $this->key_conf=$tableArrayByType.$this->type.$this->key_conf;

        // query update
        $query = "UPDATE
                    " . $this->table_conf . "
                    SET
                    label=:label, enabled=:enabled, fieldorder=:fieldorder
                    WHERE
                    " . $this->key_conf . " = :id_conf";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind values
       $stmt->bindParam(":label", $this->label);
        $stmt->bindParam(":enabled", $this->enabled);
        $stmt->bindParam(":fieldorder", $this->fieldorder);
        $stmt->bindParam(":id_conf", $this->id_conf);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    // TODO create new custom value 
    function createCustomValue(){

        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->type=htmlspecialchars(strip_tags($this->type));
        $this->id_conf=htmlspecialchars(strip_tags($this->id_conf));
        $this->value=htmlspecialchars(strip_tags($this->value));
        
        $this->table_value=$tableArrayByType.$this->type.$this->table_value;
        $this->key_conf=$tableArrayByType.$this->type.$this->key_conf;

        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_value . "
                SET
                " . $this->key_conf . " = :id_conf
                id=:id, value=:value";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // bind values
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":id_conf", $this->id_conf);
        $stmt->bindParam(":value", $this->value);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;

    }

    // TODO update the personcustom value
    function updateCustomValue(){

        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->type=htmlspecialchars(strip_tags($this->type));
        $this->value=htmlspecialchars(strip_tags($this->value));
        
        $this->table_value=$tableArrayByType.$this->type.$this->table_value;
        $this->key_value=$tableArrayByType.$this->type.$this->key_value;

        // query to insert record
        $query = "UPDATE
                    " . $this->table_value . "
                SET
                id=:id, value=:value
                WHERE
                " . $this->key_value . " = :id_value
                ";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // bind values
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":id_value", $this->id_value);
        $stmt->bindParam(":value", $this->value);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;

   }

   // TODO delete CustomParam y CustomValues en cascada... (table_value where key_value = id_conf)
    function delete(){
    
       // delete query
       $query = "DELETE FROM " . $this->table_name . " WHERE idPerson = ?";
    
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