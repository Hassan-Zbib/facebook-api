<?php 

require 'authenticate.php';
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');

$bad_request = [];
$bad_request['message'] ='Bad Request';

// get the user data of the person i wanna add 
// and then add that person to friends and pend the request

    $query = $db->prepare("INSERT INTO friends(user_id,friend_id) VALUES (?,?)"); 
    $query->bind_param("ss", $user_id,$friend_id);
    $query->execute();

    $array_response["status"] = "Added Successfully!";

$json_response = json_encode($array_response);
echo $json_response;

$query->close();
$db->close();

?>
