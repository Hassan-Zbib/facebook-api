<?php

    require_once(dirname(__FILE__)."/../authenticate.php");
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods');


    $bad_request = [ 'message' => 'Bad Request'];

    $post = json_decode(file_get_contents("php://input"));

    //validate user
    $token = isset($post->token) 
                ? $db->real_escape_string($post->token) 
                : die(json_encode($bad_request));

    $temp = validateUser($token);

    $user_id = !empty($temp)
                ? $temp
                : die(json_encode(['message' => 'Not Authorized']));

    // turnary / ifs to check post data

    // if(isset($_POST['but_upload'])){
    // $name = $_FILES['file']['name'];
    // $target_dir = "upload/";
    // $target_file = $target_dir . basename($_FILES["file"]["name"]);
  
    // // Select file type
    // $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  
    // // Valid file extensions
    // $extensions_arr = array("jpg","jpeg","png","gif");
  
    // // Check extension
    // if( in_array($imageFileType,$extensions_arr) ){
    //    // Upload file
    //    if(move_uploaded_file($_FILES['file']['tmp_name'],$target_dir.$name)){
    //       // Insert record
    //       $query = "insert into images(name) values('".$name."')";
    //       mysqli_query($con,$query);
    //    }
  
//     }
// }
   
  


    $picture = isset($post->picture) 
                ? $db->real_escape_string($post->picture)
                : die(json_encode($bad_request));

    // update status
    $query =$db->prepare("UPDATE statuses SET content = ? WHERE id = ? AND user_id = ?;");
    $query->bind_param("sii", $content, $status_id, $user_id);
    $query->execute();

    echo json_encode(
        array('message' => 'Picture Uploaded')
    );

      $query->close();
      $db->close();
?>