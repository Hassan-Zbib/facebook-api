<?php 

// Using the PHP-JWT library
require '../vendor/autoload.php';
require '../config/database.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;


function validateUser($token) {
    $decoded_token = JWT::decode($token, new Key($key, 'HS256'));
    $decoded_array = (array) $decoded_token;
    $user_id = $decoded_array['user_id'];
    $email = $decoded_array['email'];

    $query = $db->prepare("SELECT name FROM users WHERE id = ? AND email = ?");
    $query->bind_param("ss", $user_id, $email);
    $query->execute();
    $query->store_result();
    $num_rows = $query->num_rows;

    return ($num_rows !== 0);
};

function getJWT() {

};

function checkPassword() {

};



$key = jwt_key;
$payload = array(
    "user_id" => "1",
    "email" => "Hassan.zbib01@gmail.com"
);


$jwt = JWT::encode($payload, $key, 'HS256');

echo $jwt;

$decoded = JWT::decode($jwt, new Key($key, 'HS256'));

print_r($decoded);

$decoded_array = (array) $decoded;

echo json_encode($decoded_array['email']);

JWT::$leeway = 60; // $leeway in seconds
$decoded = JWT::decode($jwt, new Key($key, 'HS256'));

?>