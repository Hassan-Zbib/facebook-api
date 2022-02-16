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
    $record_id = isset($post->record_id) 
                ? $db->real_escape_string($post->record_id)
                : die(json_encode($bad_request));


    // remove friend-request
    $query =$db->prepare("UPDATE friends SET request=? WHERE id = ?");
    $query->bind_param("si", $request, $record_id);
    $query->execute();

    echo json_encode(['message' => 'Accepted']);

      $query->close();
      $db->close();
?>