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
    $content = isset($post->content)
                ? $db->real_escape_string($post->content) 
                : die(json_encode($bad_request));


    // insert status
    $query =$db->prepare("INSERT INTO statuses (user_id, content) VALUES (?, ?);");
    $query->bind_param("is", $user_id, $content);
    $query->execute();

    echo json_encode(['message' => 'Status Created']);

      $query->close();
      $db->close();
?>