<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate coproperty object
include_once '../objects/coproperty.php';
 
$database = new Database();
$db = $database->getConnection();
 
$coproperty = new Coproperty($db);
$suscriptionDate = date('Y-m-d H:i:s');
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// set coproperty property values
$coproperty->firstName = $data->firstName;
$coproperty->$lastName = $data->lastName;
$coproperty->$phoneNumber = $data->phoneNumber;
$coproperty->$address = $data->address;
$coproperty->$email = $data->email;
$coproperty->$password = $data->password;
$coproperty->$language = $data->language;
$coproperty->$suscriptionDate = $suscriptionDate;
$coproperty->$lastUpdate = $suscriptionDate;
$coproperty->$enabled = 0;
 
// create the coproperty
if($coproperty->create()){
    echo '{';
        echo '"message": "coproperty was created."';
    echo '}';
}
 
// if unable to create the coproperty, tell the user
else{
    echo '{';
        echo '"message": "Unable to create coproperty."';
    echo '}';
}
?>