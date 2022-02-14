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

    $status_id = isset($post->status_id) 
                ? $db->real_escape_string($post->status_id)
                : die(json_encode($bad_request));

    $is_liked = isset($post->is_liked) 
                ? $db->real_escape_string($post->is_liked)
                : die(json_encode($bad_request));



    if($is_liked) {
        $stmt_1 = "INSERT INTO likes (user_id, status_id) VALUES (?, ?);";
        $stmt_2 = "UPDATE statuses SET likes_count = likes_count + 1 WHERE id = ?;";
    } else {
        $stmt_1 = "DELETE FROM likes WHERE user_id = ? AND status_id = ?;";
        $stmt_2 = "UPDATE statuses SET likes_count = likes_count - 1 WHERE id = ?;";
    }

    // like or unlike status and update likes_count
    $query = $db->prepare($stmt_1);
    $query->bind_param("ii", $user_id, $status_id);

    // update status likes_count
    $update_query = $db->prepare($stmt_2);
    $update_query->bind_param("i", $status_id);

    $query->execute();
    $update_query->execute();


    echo json_encode(['message' => 'Done']);

      $query->close();
      $db->close();
?>