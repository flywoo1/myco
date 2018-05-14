<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/person.php';
include_once '../objects/customParam.php';
include_once '../objects/roles/owner.php';
include_once '../objects/roles/renter.php';
include_once '../objects/roles/administrator.php';
include_once '../objects/roles/staff.php';
 
// instantiate database and person object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$person = new Person($db);

// set ID property of person to be edited
$person->idPerson = isset($_GET['idPerson']) ? $_GET['idPerson'] : die();

// query persons
$stmt = $person->readOne();
 
    // persons array
    $persons_arr=array();
    $persons_arr["records"]=array();
 
    // retrieve our table contents
    $persons_arr=array(
        "idPerson" => $person->idPerson,
        "firstName" => $person->firstName,
        "lastName" => $person->lastName,
        "phoneNumber" => $person->phoneNumber,
        "address" => html_entity_decode($person->address),
        "email" => $person->email,
        "password" => $person->password,
        "language" => $person->language,
        "suscriptionDate" => $person->suscriptionDate,
        "lastUpdate" => $person->lastUpdate,
        "enabled" => $person->enabled,
        "roles" => $person->roles
    );

    // assoc roles
    $owner = new Owner($db);
    $owner->idPerson=$person->idPerson;

    // query owner rol
    $stmt = $owner->readByIdPerson();
    $num = $stmt->rowCount();
    // check if more than 0 record found
    if($num>0){
        // retrieve our table contents
        // fetch() is faster than fetchAll()
        // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

            extract($row);
    
            $owner_arr=array(
                "idOwner" => $idOwner,
                "idProperty" => $idProperty,
                "idCoproperty" => $idCoproperty,
                "enabled" => $enabled,
                "living" => $living,
                "suscriptionDate" => $suscriptionDate,
                "customParams" => $owner->customParams
            );
    
            

            // assoc CustomParam push custom params by copro by EntityId 1 (owner)
            // initialize object
            $customParam = new CustomParam($db);
            $customParam->idEntity=1;
            $customParam->idCoproperty=$owner_arr["idCoproperty"];
            $customParam->id=$owner_arr["idOwner"]; 

            // query customParam
            $stmtC = $customParam->readByIdEntity();
            $numC= $stmtC->rowCount();
            // check if more than 0 record found
            if($numC>0){
                // retrieve our table contents
                // fetch() is faster than fetchAll()
                // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
                while ($rowC = $stmtC->fetch(PDO::FETCH_ASSOC)){

                    extract($rowC);
            
                    $customParam_arr=array(
                        "id_conf" => $id_conf,
                        "id_value" => $id_value,
                        "type" => $type,
                        "label" => $label,
                        "value" => $value,
                        "fieldorder" => $fieldorder
                    );
            
                    array_push($owner_arr["customParams"], $customParam_arr);
                }
            }
            array_push($persons_arr["roles"], $owner_arr);
        }
    }

    $renter = new Renter($db);
    $renter->idPerson=$person->idPerson;

    // query renter rol
    $stmt = $renter->readByIdPerson();
    $num = $stmt->rowCount();
    // check if more than 0 record found
    if($num>0){
        // retrieve our table contents
        // fetch() is faster than fetchAll()
        // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

            extract($row);
    
            $renter_arr=array(
                "idRenter" => $idRenter,
                "idProperty" => $idProperty,
                "idCoproperty" => $idCoproperty,
                "enabled" => $enabled,
                "suscriptionDate" => $suscriptionDate,
                "customParams" => $renter->customParams
            );
    
            

            // assoc CustomParam push custom params by copro by EntityId 1 (renter)
            // initialize object
            $customParam = new CustomParam($db);
            $customParam->idEntity=2;
            $customParam->idCoproperty=$renter_arr["idCoproperty"];
            $customParam->id=$renter_arr["idRenter"]; 

            // query customParam
            $stmtC = $customParam->readByIdEntity();
            $numC= $stmtC->rowCount();
            // check if more than 0 record found
            if($numC>0){
                // retrieve our table contents
                // fetch() is faster than fetchAll()
                // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
                while ($rowC = $stmtC->fetch(PDO::FETCH_ASSOC)){

                    extract($rowC);
            
                    $customParam_arr=array(
                        "id_conf" => $id_conf,
                        "id_value" => $id_value,
                        "type" => $type,
                        "label" => $label,
                        "value" => $value,
                        "fieldorder" => $fieldorder
                    );
            
                    array_push($renter_arr["customParams"], $customParam_arr);
                }
            }
            array_push($persons_arr["roles"], $renter_arr);
        }
    }
    
    $staff = new Staff($db);
    $staff->idPerson=$person->idPerson;

    // query staff rol
    $stmt = $staff->readByIdPerson();
    $num = $stmt->rowCount();
    // check if more than 0 record found
    if($num>0){
        // retrieve our table contents
        // fetch() is faster than fetchAll()
        // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

            extract($row);
    
            $staff_arr=array(
                "idStaff" => $idStaff,
                "idTicketScope" => $idTicketScope,
                "idCoproperty" => $idCoproperty,
                "enabled" => $enabled,
                "suscriptionDate" => $suscriptionDate,
                "customParams" => $staff->customParams
            );
    
            

            // assoc CustomParam push custom params by copro by EntityId 1 (staff)
            // initialize object
            $customParam = new CustomParam($db);
            $customParam->idEntity=2;
            $customParam->idCoproperty=$staff_arr["idCoproperty"];
            $customParam->id=$staff_arr["idStaff"]; 

            // query customParam
            $stmtC = $customParam->readByIdEntity();
            $numC= $stmtC->rowCount();
            // check if more than 0 record found
            if($numC>0){
                // retrieve our table contents
                // fetch() is faster than fetchAll()
                // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
                while ($rowC = $stmtC->fetch(PDO::FETCH_ASSOC)){

                    extract($rowC);
            
                    $customParam_arr=array(
                        "id_conf" => $id_conf,
                        "id_value" => $id_value,
                        "type" => $type,
                        "label" => $label,
                        "value" => $value,
                        "fieldorder" => $fieldorder
                    );
            
                    array_push($staff_arr["customParams"], $customParam_arr);
                }
            }
            array_push($persons_arr["roles"], $staff_arr);
        }
    }

    $administrator = new Administrator($db);
    $administrator->idPerson=$person->idPerson;

    // query administrator rol
    $stmt = $administrator->readByIdPerson();
    $num = $stmt->rowCount();
    // check if more than 0 record found
    if($num>0){
        // retrieve our table contents
        // fetch() is faster than fetchAll()
        // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

            extract($row);
    
            $administrator_arr=array(
                "idAdministrator" => $idAdministrator,
                "idCoproperty" => $idCoproperty,
                "enabled" => $enabled,
                "customParams" => $administrator->customParams
            );
    
            

            // assoc CustomParam push custom params by copro by EntityId 1 (administrator)
            // initialize object
            $customParam = new CustomParam($db);
            $customParam->idEntity=2;
            $customParam->idCoproperty=$administrator_arr["idCoproperty"];
            $customParam->id=$administrator_arr["idAdministrator"]; 

            // query customParam
            $stmtC = $customParam->readByIdEntity();
            $numC= $stmtC->rowCount();
            // check if more than 0 record found
            if($numC>0){
                // retrieve our table contents
                // fetch() is faster than fetchAll()
                // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
                while ($rowC = $stmtC->fetch(PDO::FETCH_ASSOC)){

                    extract($rowC);
            
                    $customParam_arr=array(
                        "id_conf" => $id_conf,
                        "id_value" => $id_value,
                        "type" => $type,
                        "label" => $label,
                        "value" => $value,
                        "fieldorder" => $fieldorder
                    );
            
                    array_push($administrator_arr["customParams"], $customParam_arr);
                }
            }
            array_push($persons_arr["roles"], $administrator_arr);
        }
    }

    // make it json format
    //print_r 
    echo json_encode($persons_arr);
?>