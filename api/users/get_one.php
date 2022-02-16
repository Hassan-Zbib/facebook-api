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


    // remove friend-request
    $query =$db->prepare("SELECT id, name, email, created_at  FROM users WHERE id = ?");
    $query->bind_param("i", $friend_id);
    $query->execute();

  // bind results
  $query->bind_result($id, $name, $email, $created_at);
  $query->fetch();

  $array_response = [
      'friend_id' => $id,
      'name' => $name,
      'email' => strtolower($email),
      'created_at' => $created_at,
  ];
  
  $json_response = json_encode($array_response);
  echo $json_response;
?>