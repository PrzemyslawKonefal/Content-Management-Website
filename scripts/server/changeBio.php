<?php
  session_start();
    if ((!isset($_SESSION['UserData'])) && (!isset($_POST['bio']))){
       header("Location: ../../");
       exit();
    }
     $userID = $_SESSION['UserData']['ID'];
     require_once"connect.php";

  $connection = @new mysqli($host, $db_user, $db_password, $db_name);
  if ($connection->connect_errno!=0) {
    echo "Error: ".$connection->connect_errno;
  }
  else{
        $connection->query("UPDATE users SET bio = '{$_POST['bio']}' WHERE ID = '{$userID}'");
        $_SESSION['bioChanged'] = true;
        $_SESSION['UserData']['bio'] = $_POST['bio'];
        header("Location: ../../profil.php");
  }
 ?>
