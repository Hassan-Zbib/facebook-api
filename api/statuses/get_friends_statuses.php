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

    // check if is friend
    $friend_request = "accepted";
    $query =$db->prepare("SELECT * FROM friends WHERE user_id = ? AND friend_id = ? AND request = ?;");
    $query->bind_param("iis", $user_id, $friend_id, $friend_request);
    $query->execute();
    $query->store_result();
    if ($query->num_rows === 0) {
        die(json_encode(['message' => 'Users are not friends']));
    }

    // get statuses
    $query =$db->prepare("SELECT s.*,   CASE 
                                            WHEN ? in (SELECT DISTINCT user_id FROM likes WHERE status_id = s.id) THEN 1
                                            ELSE 0
                                        END as is_liked
                        FROM statuses s
                        WHERE user_id = ?
                        ;");

    $query->bind_param("ii", $user_id, $friend_id);
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