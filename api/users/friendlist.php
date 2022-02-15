<?php 

require_once(dirname(__FILE__)."/../authenticate.php");
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');

$bad_request = [];
$bad_request['message'] ='Bad Request';

$query = $db->prepare("Select * FROM users;");
$query->execute();

$array = $query->get_result();

$array_response = [];
while($user = $array->fetch_assoc()){
    $array_response[] = $user;
}

$json_response = json_encode($array_response);
echo $json_response;

$query->close();
$db->close();

?>