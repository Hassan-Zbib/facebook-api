<?php

    require_once(dirname(__FILE__)."/../authenticate.php");
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods');


    $bad_request = array(
        'message' => 'Bad Request'
    );

    $del = json_decode(file_get_contents("php://input"));

    // turnary / ifs to check post data
    $status_id = isset($del->status_id) 
                ? $db->real_escape_string($del->status_id)
                : die(json_encode($bad_request));

    // delete status
    $query =$db->prepare("DELETE FROM statuses WHERE id = ?;");
    $query->bind_param("i", $status_id);
    $query->execute();

    echo json_encode(
        array('message' => 'Status Deleted')
    );

      $query->close();
      $db->close();
?>