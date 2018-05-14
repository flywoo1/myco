<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/coproperty.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare coproperty object
$coproperty = new Coproperty($db);
 
// get id of coproperty to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of coproperty to be edited
$coproperty->idCoproperty = $data->idCoproperty;
 
// set coproperty property values
$coproperty->identification = $data->identification;
$coproperty->address = $data->address;
$coproperty->latitud = $data->latitud;
$coproperty->longitud = $data->longitud;
$coproperty->suscriptionDate = $data->suscriptionDate;
$coproperty->lastUpdate = $data->lasUpdate;
$coproperty->enabled = $data->enabled;
 
// update the coproperty
if($coproperty->update()){
    echo '{';
        echo '"message": "coproperty was updated."';
    echo '}';
}
 
// if unable to update the coproperty, tell the user
else{
    echo '{';
        echo '"message": "Unable to update coproperty."';
    echo '}';
}
?>