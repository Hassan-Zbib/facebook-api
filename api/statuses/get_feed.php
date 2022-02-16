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

    // get feed
    $friend_request = "accepted";
    $query =$db->prepare("SELECT s.*, u.name, u.email,  CASE 
                                            WHEN ? in (SELECT DISTINCT user_id FROM likes WHERE status_id = s.id) THEN 1
                                            ELSE 0
                                        END as is_liked
                        FROM statuses s
                        INNER JOIN users u ON s.user_id = u.id 
                        INNER JOIN friends f ON s.user_id = f.user_id OR s.user_id = f.friend_id
                        WHERE s.user_id != ? AND f.request = ?
                        ;");

    $query->bind_param("iis", $user_id, $user_id, $friend_request);
    $query->execute();

    $data = $query->get_result();
    $response = [];
    while($status = $data->fetch_assoc()){
        $status['is_liked'] = $status['is_liked'] === 1;
        $response[] = $status;
    }

    echo json_encode($response);

      $query->close();
      $db->close();
?>