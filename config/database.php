<?php 

  $db_host = 'localhost';
  $db_name = 'facebookdb';
  $db_user = 'root';
  $db_pass = '';

  //  Connect

  $db =  new mysqli($db_host, $db_user, $db_pass, $db_name);

  // Check connection
  if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      exit();
  }
  

?>