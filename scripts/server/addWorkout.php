<?php
session_start();
if (!isset($_POST['time'])) {
  header('Location: ../../index.php');
  exit();
}
require_once"connect.php";
$time = $_POST['time'];
$type = $_POST['type'];
$type = htmlentities($type, ENT_QUOTES, "UTF-8");
$description = $_POST['description'];
$description = htmlentities($description, ENT_QUOTES, "UTF-8");
$id = $_SESSION['UserData']['ID'];
$owner = $_SESSION['UserData']['nick'];
$connection = @new mysqli($host, $db_user, $db_password, $db_name);
    if ($connection->connect_errno!=0) {
      echo "Error: ".$connection->connect_errno;
    }
    else{
      if ($connection->query("INSERT INTO workouts VALUES (NULL, '$time', '$type', '$description', now(), '$id', '$owner')")) {
            $result = $connection->query("SELECT workout_num, workout_time FROM users WHERE ID = {$id}");
            $row = $result->fetch_assoc();
            $time += $row['workout_time'];
            $work_num = $row['workout_num'] + 1;
            $connection->query("UPDATE users SET workout_num={$work_num}, workout_time={$time} WHERE ID={$id}");
      }
       header('Location: ../../index.php');
    }
 ?>
