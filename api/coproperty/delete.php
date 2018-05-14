<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
 
// include database and object file
include_once '../config/database.php';
include_once '../objects/coproperty.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare coproperty object
$coproperty = new Coproperty($db);
 
// get coproperty id
$data = json_decode(file_get_contents("php://input"));
 
// set coproperty id to be deleted
$coproperty->idCoproperty = $data->idCoproperty;
 
// delete the coproperty
if($coproperty->delete()){
    echo '{';
        echo '"message": "coproperty was deleted."';
    echo '}';
}
 
// if unable to delete the coproperty
else{
    echo '{';
        echo '"message": "Unable to delete object."';
    echo '}';
}
?>