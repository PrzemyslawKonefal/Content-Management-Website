<?php
session_start();
if (!isset($_POST['postID'])) {
  header('Location: ../../index.php');
  exit();
}
  require_once"connect.php";

  $isVerified = 0;
  if (isset($_SESSION['UserData'])) $isVerified = 1;
  $content = $_POST['content'];
  $content = htmlentities($content, ENT_QUOTES, "UTF-8");
  $name = $_POST['name'];
  $name = htmlentities($name, ENT_QUOTES, "UTF-8");
  $postID = $_POST['postID'];
  $postID = htmlentities($postID, ENT_QUOTES, "UTF-8");
  $connection = @new mysqli($host, $db_user, $db_password, $db_name);
  if ($connection->connect_errno!=0) {
    echo "Error: ".$connection->connect_errno;
  }
  else{
    $connection->query("INSERT INTO comments VALUES (NULL, '$name', '$content', '0', '$isVerified', '$postID', now())");
    header("Location: ../../".$_SESSION['location']);
  }

?>
