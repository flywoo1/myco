<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/person.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare person object
$person = new Person($db);
 
// get id of person to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of person to be edited
$person->idPerson = $data->id;
 
// set person property values
$person->firstName = $data->firstName;
$person->lastName = $data->lastName;
$person->phoneNumber = $data->phoneNumber;
$person->address = $data->address;
$person->email = $data->email;
$person->password = $data->password;
$person->language = $data->language;
$person->lastUpdate = date('Y-m-d H:i:s');
$person->enabled = $data->enabled;
 
// update the person
if($person->update()){
    echo '{';
        echo '"message": "person was updated."';
    echo '}';
}
 
// if unable to update the person, tell the user
else{
    echo '{';
        echo '"message": "Unable to update person."';
    echo '}';
}
?>