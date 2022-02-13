<?php 

// Using the PHP-JWT library
require '../vendor/autoload.php';
require '../config/database.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;


function validateUser($token) {
    try {   
        
        // decode will check for validity/expiration
        $decoded_token = JWT::decode($token, new Key(jwt_key, 'HS256'));
        $decoded_array = (array) $decoded_token;
        $user_id = $decoded_array['user_id'];

    } catch (\Exception $e) {
        return false;
    };
    return $user_id;
};


function getJWT($id) {

    $key = jwt_key; // secret key in config file
    $iat = time(); //  token issued time
    $exp = $iat + 3600; // token expiry time
    $payload = array(
        "user_id" => $id,
        "iat" => $iat,
        "exp" => $exp
    );

    $jwt = JWT::encode($payload, $key, 'HS256');
    return $jwt;
};


?>