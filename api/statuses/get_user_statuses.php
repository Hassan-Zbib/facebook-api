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


    // get statuses
    $query =$db->prepare("SELECT * FROM statuses WHERE user_id = ?;");
    $query->bind_param("i", $user_id);
    $query->execute();

    $data = $query->get_result();
    $response = [];
    while($status = $data->fetch_assoc()){
        $response[] = $status;
    }

    echo json_encode($response);

      $query->close();
      $db->close();
?>