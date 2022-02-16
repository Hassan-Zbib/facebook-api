<?php

    require_once(dirname(__FILE__)."/authenticate.php");
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods');


    $bad_request = ['message' => 'Bad Request'];

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
    $query = $db->prepare("SELECT id, name, password, picture, created_at FROM users WHERE email = ?;");
    $query->bind_param("s", $email);
    $query->execute();
    $query->store_result();

    // Get the number of rows 
    $num_rows = $query->num_rows;
    // bind results
    $query->bind_result($id, $name, $pass, $picture, $created_at);
    $query->fetch();

    if ($password !== $pass){
        die(json_encode(['message' => 'Password is incorrect']));
    } elseif ($num_rows == 0) {
        die(json_encode(['message' => 'User not found']));
    }

    $jwt = getJWT($id);

    $array_response = [
        'status' => 'Validated',
        'user_id' => $id,
        'name' => $name,
        'email' => strtolower($email),
        'picture' => $picture,
        'created_at' => $created_at,
        'token' => $jwt
    ];
    
    $json_response = json_encode($array_response);
    echo $json_response;

    $query->close();
    $db->close();

?>