<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
 
// include database and object file
include_once '../config/database.php';
include_once '../objects/person.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare person object
$person = new Person($db);
 
// get person id
$data = json_decode(file_get_contents("php://input"));
 
// set person id to be deleted
$person->idPerson = $data->id;
 
// delete the person
if($person->delete()){
    echo '{';
        echo '"message": "person was deleted."';
    echo '}';
}
 
// if unable to delete the person
else{
    echo '{';
        echo '"message": "Unable to delete object."';
    echo '}';
}
?>