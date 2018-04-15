<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/person.php';
 
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
        "fiestName" => $person->firstName,
        "lastName" => $person->lastName,
        "phoneNumber" => $person->phoneNumber,
        "address" => html_entity_decode($person->address),
        "email" => $person->email,
        "language" => $person->language,
        "suscriptionDate" => $person->suscriptionDate,
        "lastUpdate" => $person->lastUpdate,
        "enabled" => $person->enabled
    );
    // make it json format
    //print_r 
    echo json_encode($persons_arr);
?>