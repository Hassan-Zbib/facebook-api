<?php

    require_once(dirname(__FILE__)."/authenticate.php");
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods');


    $bad_request = array(
        'message' => 'Bad Request'
    );

    $post = json_decode(file_get_contents("php://input"));

    // ternary / ifs to check post data
    $email = isset($post->email) 
            ? $db->real_escape_string($post->email) 
            : die(json_encode($bad_request));

    $password = isset($post->password) 
                ? $db->real_escape_string($post->password) 
                : die(json_encode($bad_request));
                
    $password = hash("sha256", $password);

    // query user
    $query = $db->prepare("SELECT id, name, password FROM users WHERE email = ?;");
    $query->bind_param("s", $email);
    $query->execute();
    $query->store_result();

    // Get the number of rows 
    $num_rows = $query->num_rows;
    // bind results
    $query->bind_result($id, $name, $pass);
    $query->fetch();

    if ($password !== $pass){
        $bad_request['message'] ='Password is incorrect';
        die(json_encode($bad_request));
    } elseif ($num_rows == 0) {
        $bad_request['message'] ='User not found';
        die(json_encode($bad_request));
    }

    $jwt = getJWT($id);

    $array_response = array(
        'status' => 'Validated',
        'user_id' => $id,
        'name' => $name,
        'email' => strtolower($email),
        'token' => $jwt
    );
    
    $json_response = json_encode($array_response);
    echo $json_response;

    $query->close();
    $db->close();

?>