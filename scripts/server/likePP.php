<?php
  if (!isset($_POST['commentId'])) exit();
  require_once"connect.php";
  $connection = @new mysqli($host, $db_user, $db_password, $db_name);
  if ($connection->connect_errno!=0) {
    echo "Error: ".$connection->connect_errno; exit();
  }
  else{
    if($_POST['table'] == "comments"){
      $result = $connection->query("UPDATE comments SET Likes = Likes + 1 WHERE Comments_ID = {$_POST['commentId']}");
    }
    else{
      $result = $connection->query("UPDATE workouts SET Likes = Likes + 1 WHERE ID = {$_POST['commentId']}");
    }
    echo "success";
  }
 ?>
