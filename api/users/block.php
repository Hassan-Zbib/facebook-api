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

    //get the user data of the person i wanna block 
    // then change the status of is_blocked in the database regarding the user 
        $query = $db->prepare("INSERT INTO blocks(user_id,friend_id) VALUES (?,?)"); 
        $query->bind_param("ss", $user_id,$friend_id);
        $query->execute();

        

    $query->close();
    $db->close();

?>
