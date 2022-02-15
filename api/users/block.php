<?php 

require_once(dirname(__FILE__)."/../authenticate.php");
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');

$bad_request = [];
$bad_request['message'] ='Bad Request';

//get the user data of the person i wanna block 
// then change the status of is_blocked in the database regarding the user 
    $query = $db->prepare("INSERT INTO blocks(user_id,friend_id) VALUES (?,?)"); 
    $query->bind_param("ss", $user_id,$friend_id);
    $query->execute();

    

$query->close();
$db->close();

?>
