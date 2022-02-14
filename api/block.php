<?php 

require 'authenticate.php';
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');

$bad_request = [];
$bad_request['message'] ='Bad Request';

//get the user data of the person i wanna block 
// then change the status of is_blocked in the database regarding the user 

$select = mysqli_query($db, "SELECT * FROM users WHERE email = '".$_POST['email']."'");
if(mysqli_num_rows($select)) {
    die('You already have an account!');
}else{
    $query = $db->prepare("INSERT INTO users(name,email,password) VALUES (?,?,?)"); 
    $query->bind_param("sss", $name, $email, $password);
    $query->execute();

    $array_response["status"] = "Signed Up successfully!";

}

$json_response = json_encode($array_response);
echo $json_response;

$query->close();
$db->close();

?>
