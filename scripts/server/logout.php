<?php
    session_start();
    if (isset($_SESSION['UserData'])) {
      unset($_SESSION['UserData']);
      header("Location: ../../index.php");
    }
    else{
      header('Location: ../index.php');
    }
 ?>
