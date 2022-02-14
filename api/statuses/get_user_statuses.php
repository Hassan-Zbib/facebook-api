<?php

    require_once(dirname(__FILE__)."/../authenticate.php");
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: GET');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods');


    $bad_request = array(
        'message' => 'Bad Request'
    );

    $get = json_decode(file_get_contents("php://input"));

    // turnary / ifs to check get data
    $user_id = isset($get->user_id) 
                ? $db->real_escape_string($get->user_id)
                : die(json_encode($bad_request));


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