<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/coproperty.php';
include_once '../objects/customParam.php';
include_once '../objects/roles/owner.php';
include_once '../objects/roles/renter.php';

// instantiate database and coproperty object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$coproperty = new Coproperty($db);

// set ID property of coproperty to be edited
$coproperty->idCoproperty = isset($_GET['idCoproperty']) ? $_GET['idCoproperty'] : die();

// query copropertys
$stmt = $coproperty->readOne();
 
    // copropertys array
    $copropertys_arr=array();
    $copropertys_arr["records"]=array();
 
    // retrieve our table contents
    $copropertys_arr=array(
        "idCoproperty" => $coproperty->idCoproperty,
        "identification" => $coproperty->identification,
        "address" => html_entity_decode($coproperty->address),
        "latitud" => $coproperty->latitud,
        "longitud" => $coproperty->longitud,
        "suscriptionDate" => $coproperty->suscriptionDate,
        "lastUpdate" => $coproperty->lastUpdate,
        "enabled" => $coproperty->enabled,
        "customParams" => $coproperty->customParams,
        "numberOfProperties" => $coproperty->numberOfProperties,
        "numberOfOwners" => $coproperty->numberOfOwners,
        "numberOfLivingOwners" => $coproperty->numberOfLivingOwners,
        "numberOfRenters" => $coproperty->numberOfRenters
    );
    
    // assoc CustomParam push custom params by copro by EntityId 5 (coproperty)
    // initialize object
    $customParam = new CustomParam($db);
    $customParam->idEntity=5;
    $customParam->idCoproperty=$coproperty->idCoproperty;
    $customParam->id=$coproperty->idCoproperty; 

    // query copropertys
    $stmt = $customParam->readByIdEntity();
    $num = $stmt->rowCount();
    // check if more than 0 record found
    if($num>0){
        // retrieve our table contents
        // fetch() is faster than fetchAll()
        // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

            extract($row);
    
            $customParam_arr=array(
                "id_conf" => $id_conf,
                "id_value" => $id_value,
                "type" => $type,
                "label" => $label,
                "value" => $value,
                "fieldorder" => $fieldorder
            );
    
            array_push($copropertys_arr["customParams"], $customParam_arr);
        }
    }

    //add number of owners, living ones, renters
    $owner = new Owner($db);
    $owner->idCoproperty=$coproperty->idCoproperty;

    $stmt = $owner->countByIdCopro();
    $num = $stmt->rowCount();
    if($num>0){
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);
        $copropertys_arr["numberOfOwners"] += $number;
    }

    //add number of living ones
    $stmt = $owner->livingCountByIdCopro();
    $num = $stmt->rowCount();
    if($num>0){
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);
        $copropertys_arr["numberOfLivingOwners"] += $number;
    }

    //add number renters
    $renter = new Renter($db);
    $renter->idCoproperty=$coproperty->idCoproperty;

    $stmt = $renter->countByIdCopro();
    $num = $stmt->rowCount();
    if($num>0){
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);
        $copropertys_arr["numberOfRenters"] += $number;
    }
    
    // make it json format
    //print_r 
    echo json_encode($copropertys_arr);
    
?>