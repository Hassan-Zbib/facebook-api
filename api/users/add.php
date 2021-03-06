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

    $friend_id = isset($post->friend_id) 
                ? $db->real_escape_string($post->friend_id)
                : die(json_encode($bad_request));

        $request = "pending";
        $query = $db->prepare("INSERT INTO friends(user_id,friend_id,request) VALUES (?,?,?)"); 
        $query->bind_param("iis", $user_id,$friend_id,$request);
        $query->execute();

        echo json_encode(['message' => 'Request sent']);

    $query->close();
    $db->close();

?>
