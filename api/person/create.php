<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate person object
include_once '../objects/person.php';
 
$database = new Database();
$db = $database->getConnection();
 
$person = new Person($db);
$suscriptionDate = date('Y-m-d H:i:s');

function random_password() 
{
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $password = array(); 
    $alpha_length = strlen($alphabet) - 1; 
    for ($i = 0; $i < 8; $i++) 
    {
        $n = rand(0, $alpha_length);
        $password[] = $alphabet[$n];
    }
    return implode($password); 
} 
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// set person property values
$person->firstName = $data->firstName;
$person->lastName = $data->lastName;
$person->phoneNumber = $data->phoneNumber;
$person->address = $data->address;
$person->email = $data->email;
$person->password = random_password();
$person->language = 'fr'; // $data->language;
$person->suscriptionDate = $suscriptionDate;
$person->lastUpdate = $suscriptionDate;
$person->enabled = 0;
 
// create the person
if($person->create()){
    echo '{';
        echo '"message": "Person was created."';
    echo '}';
}
 
// if unable to create the person, tell the user
else{
    echo '{';
        echo '"message": "Unable to create person."';
    echo '}';
}
?>