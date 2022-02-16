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

    $block = isset($post->block) 
                ? $db->real_escape_string($post->block)
                : die(json_encode($bad_request));

    // remove-add block
    if($block) {
        $stmt = "INSERT INTO blocks (user_id, friend_id) VALUES (?, ?);";
        $msg = "User Blocked";
    } else {
        $stmt = "DELETE FROM blocks WHERE user_id = ? AND friend_id = ? ;";
        $msg = "User Unblocked";
    }

    $query =$db->prepare($stmt);
    $query->bind_param("ii", $user_id, $friend_id);
    $query->execute();

    echo json_encode(['message' => $msg]);

      $query->close();
      $db->close();
?>