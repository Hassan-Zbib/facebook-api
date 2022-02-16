<?php

    require_once(dirname(__FILE__)."/../authenticate.php");
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods');


    $bad_request = [ 'message' => 'Bad Request'];

    $post = json_decode(file_get_contents("php://input"));

    //validate user
    $token = isset($post->token) 
                ? $db->real_escape_string($post->token) 
                : die(json_encode($bad_request));

    $temp = validateUser($token);

    $user_id = !empty($temp)
                ? $temp
                : die(json_encode(['message' => 'Not Authorized']));

    // turnary / ifs to check post data
    $friend_id = isset($post->friend_id) 
                ? $db->real_escape_string($post->friend_id)
                : die(json_encode($bad_request));

    $request = isset($post->request) 
                ? $db->real_escape_string($post->request)
                : die(json_encode($bad_request));

    // remove friend-request
    $query =$db->prepare("DELETE FROM friends WHERE ( user_id = ? AND friend_id = ? ) OR ( user_id = ? AND friend_id = ? ) AND request = ? ;");
    $query->bind_param("iiiis", $user_id, $friend_id, $friend_id, $user_id, $request);
    $query->execute();

    echo json_encode(['message' => 'Removed']);

      $query->close();
      $db->close();
?>