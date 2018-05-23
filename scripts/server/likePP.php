<?php
  session_start();
  if ((!isset($_POST['commentId'])) && (!isset($_SESSION['UserData']))) exit();
  require_once"connect.php";
  $connection = @new mysqli($host, $db_user, $db_password, $db_name);
  if ($connection->connect_errno!=0) {
    echo "Error: ".$connection->connect_errno; exit();
  }
  else{
    $id = '#'.$_SESSION['UserData']['ID'].'#';
    $filter = "%".$id."%";
    if($_POST['table'] == "comments"){
      $result = $connection->query("UPDATE comments SET Likes = Likes + 1, Like_IDs = CONCAT(Like_IDs, '$id') WHERE Comments_ID = {$_POST['commentId']} AND Like_IDs NOT LIKE '{$filter}'");
    }
    else{
      $result = $connection->query("UPDATE workouts SET Likes = Likes + 1, Like_IDs = CONCAT(Like_IDs, '$id') WHERE ID = {$_POST['commentId']} AND Like_IDs NOT LIKE '{$filter}'");
    }
  }
 ?>
