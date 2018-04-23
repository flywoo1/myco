<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/coproperty.php';
 
// instantiate database and coproperty object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$coproperty = new Coproperty($db);
 
// query copropertys
$stmt = $coproperty->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // copropertys array
    $copropertys_arr=array();
    $copropertys_arr["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $coproperty_item=array(
            "idCoproperty" => $idCoproperty,
            "identification" => $identification,
            "address" => html_entity_decode($address),
            "latitud" => $latitud,
            "longitud" => $longitud,
            "suscriptionDate" => $suscriptionDate,
            "lastUpdate" => $lastUpdate,
            "enabled" => $enabled
        );
 
        array_push($copropertys_arr["records"], $coproperty_item);
    }
 
    echo json_encode($copropertys_arr);
}
 
else{
    echo json_encode(
        array("message" => "No copropertys found.")
    );
}
?>