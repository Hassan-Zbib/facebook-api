<?php 

// Using the PHP-JWT library
require '../vendor/autoload.php';
require '../config/config.php';
require '../config/database.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$key = jwt_key;

function checkUserName() {

};

function checkPassword() {

};

$payload = array(
    "iss" => "http://example.org",
    "aud" => "http://example.com",
    "iat" => 1356999524,
    "nbf" => 1357000000
);


$jwt = JWT::encode($payload, $key, 'HS256');
$decoded = JWT::decode($jwt, new Key($key, 'HS256'));


$decoded_array = (array) $decoded;

echo json_encode($decoded_array);

JWT::$leeway = 60; // $leeway in seconds
$decoded = JWT::decode($jwt, new Key($key, 'HS256'));



?>