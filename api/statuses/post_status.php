<?php

    require_once(dirname(__FILE__)."/../authenticate.php");
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods');


    $bad_request = [];
    $bad_request['message'] ='Bad Request';

    // turnary / ifs to check post data
    $user_id = isset($_POST['user_id']) 
                ? $db->real_escape_string($_POST['user_id'])
                : die(json_encode($bad_request));

    $content = isset($_POST['content'])
                ? $db->real_escape_string($_POST['content']) 
                : die(json_encode($bad_request));


    // insert status
    $query =$db->prepare("INSERT INTO statuses (user_id, content) VALUES (?, ?);");
    $query->bind_param("is", $user_id, $content);
    $query->execute();

    echo json_encode(
        array('message' => 'Status Created')
    );

      $query->close();
      $db->close();
?>