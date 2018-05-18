<?php
session_start();
  require_once"connect.php";
  if ((!isset($_POST['nick'])) || (!isset($_POST['password'])))
   {
    header('Location: ../../index.php');
    exit();
   }

   $connection = @new mysqli($host, $db_user, $db_password, $db_name);
       if ($connection->connect_errno!=0) {
         echo "Error: ".$connection->connect_errno;
       }
       else{
         $nick = $_POST['nick'];
         $password = $_POST['password'];
         $nick = htmlentities($nick, ENT_QUOTES, "UTF-8");

         if($result = @$connection->query(
           sprintf("SELECT * FROM users WHERE nick = '%s'",
           mysqli_real_escape_string($connection, $nick)))) {
             $users_number = $result->num_rows;
             if ($users_number > 0){
               $_SESSION['UserData'] = $result->fetch_assoc();

               if (password_verify($password, $_SESSION['UserData']['password'])){
                 header('Location: ../../index.php');
               }
               else{
                 unset($_SESSION['UserData']);
                 $_SESSION['Log_Err'] = "<h5 style='color:red; text-align:center'>Incorrect login or password</h5>";
                 header('Location: ../../index.php');
               }
              }
              else
              {
                $_SESSION['Log_Err'] = "<h5 style='color:red; text-align:center'>Incorrect login or password</h5>";
                header('Location: ../../index.php');
              }
              $connection->close();
           }
       }
 ?>
