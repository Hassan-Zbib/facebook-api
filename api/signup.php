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

    $name = isset($post->name) 
            ? $db->real_escape_string($post->name) 
            : die(json_encode($bad_request));

    $password = isset($post->password) 
                ? $db->real_escape_string($post->password) 
                : die(json_encode($bad_request));

    $password = hash("sha256", $password);

    // check if already exists
    $query = $db->prepare("SELECT id FROM users WHERE email = ?;");
    $query->bind_param("s", $email);
    $query->execute();
    $query->store_result();
    if ($query->num_rows !== 0) {
        die(json_encode(['message' => 'User already exists']));
    }

    // add user
    $query =$db->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?);");
    $query->bind_param("sss", $name, $email, $password);
    $query->execute();

    echo json_encode(['message' => 'User Created']);

      $query->close();
      $db->close();
?>