<?php

    require_once(dirname(__FILE__)."/../authenticate.php");
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods');


    $bad_request = [ 'message' => 'Bad Request'];

    $put = json_decode(file_get_contents("php://input"));

    //validate user
    $token = isset($put->token) 
                ? $db->real_escape_string($put->token) 
                : die(json_encode($bad_request));

    $temp = validateUser($token);

    $user_id = !empty($temp)
                ? $temp
                : die(json_encode(['message' => 'Not Authorized']));

    // turnary / ifs to check post data
    $status_id = isset($put->status_id) 
                ? $db->real_escape_string($put->status_id)
                : die(json_encode($bad_request));

    $content = isset($put->content)
                ? $db->real_escape_string($put->content) 
                : die(json_encode($bad_request));


    // update status
    $query =$db->prepare("UPDATE statuses SET content = ? WHERE id = ? AND user_id = ?;");
    $query->bind_param("sii", $content, $status_id, $user_id);
    $query->execute();

    echo json_encode(
        array('message' => 'Status Updated')
    );

      $query->close();
      $db->close();
?>