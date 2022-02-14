<?php

    require 'authenticate.php';
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods');


    $bad_request = [];
    $bad_request['message'] ='Bad Request';

    // ternary / ifs to check post data
    $email = isset($_POST['email']) 
            ? $db->real_escape_string($_POST['email']) 
            : die(json_encode($bad_request));

    $password = isset($_POST['password']) 
                ? $db->real_escape_string($_POST['password']) 
                : die(json_encode($bad_request));
                
    $password = hash("sha256", $password);

    // query user
    $query = $db->prepare("SELECT id, name, password FROM users WHERE email = ?");
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

    $array_response = [];
    $array_response["status"] = "Logged In";
    $array_response["user_id"] = $id;
    $array_response["name"] = $name;
    $array_response["email"] = strtolower($email);
    $array_response["token"] = $jwt;
    
    $json_response = json_encode($array_response);
    echo $json_response;

    $query->close();
    $db->close();

?>