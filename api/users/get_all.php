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

    

    $query = $db->prepare(" SELECT * FROM users");
    $query->execute();
    $array = $query->get_result();
    
    $array_response = [];
    while($user = $array->fetch_assoc()){
        $array_response[] = $user;
    }
    
    $json_response = json_encode($array_response);
    echo $json_response;
    
    $query->close();
    $db->close();

?>