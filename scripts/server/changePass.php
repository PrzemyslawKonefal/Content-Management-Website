<?php
  session_start();
    if ((!isset($_SESSION['UserData'])) && (!isset($_POST['passOld'])))
     {header("Location: ../../"); exit();}
  require_once"connect.php";
  $password = $_POST['passOld'];
  $userID = $_SESSION['UserData']['ID'];

  $connection = @new mysqli($host, $db_user, $db_password, $db_name);
  if ($connection->connect_errno!=0) {
    echo "Error: ".$connection->connect_errno;
  }
  else{
    $result = $connection->query("SELECT password FROM users WHERE ID = {$userID}");
    if($result->num_rows > 0){
        $dbPassword = $result->fetch_assoc();
        $allOk = true;
        if (!password_verify($password, $dbPassword['password'])) {
          $allOk = false;
        }
        if ($_POST['passNew'] != $_POST['passNew2']) {
          $allOk = false;
        }
        if ($allOk) {
          $newPassword = password_hash($_POST['passNew'], PASSWORD_DEFAULT);
          $connection->query("UPDATE users SET password = '{$newPassword}' WHERE ID = {$userID}");
          $_SESSION['passChanged'] = true;
        }
        else {
          $_SESSION['pass_Err'] = '<h1 style = "color:red; text-align: center;">Niepoprawne stare hasło lub nowe hasła nie są takie same</h1>';
        }
    }
    header("Location: ../../profil.php");
  }
 ?>
