<?php

    require_once(dirname(__FILE__)."/../authenticate.php");
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods');


    $bad_request = array(
        'message' => 'Bad Request'
    );

    $put = json_decode(file_get_contents("php://input"));

    // turnary / ifs to check post data
    $user_id = isset($put->user_id) 
                ? $db->real_escape_string($put->user_id)
                : die(json_encode($bad_request));

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