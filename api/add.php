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
    $request = "pending";
    $query = $db->prepare("INSERT INTO friends(user_id,friend_id,request) VALUES (?,?,?)"); 
    $query->bind_param("sss", $user_id,$friend_id,$request);
    $query->execute();

    echo json_encode(['status' => 'blocked']);

$query->close();
$db->close();

?>
