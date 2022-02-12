<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: GET');

  include('../../config/database.php');


  $query = $db->prepare("SELECT * FROM users;");
  $query->execute();

  $array = $query->get_result();

  $response = [];
  while($user = $array->fetch_assoc()){
      $response[] = $user;
  }

  echo json_encode($response);

?>
