<?php session_start();
  require_once"scripts/server/connect.php";
  $connection = @new mysqli($host, $db_user, $db_password, $db_name);
  if ($connection->connect_errno!=0) {
    echo "Error: ".$connection->connect_errno; exit();
  }
  else{
    $postId = htmlentities($_GET['id'], ENT_QUOTES, "UTF-8");
    $_SESSION['location'] = 'profile.php?id='.$userId;
    $result = $connection->query("SELECT * FROM workouts WHERE ID = $postId");
    if ($result ->num_rows >0) {
      $chosenPost = $result->fetch_assoc();
    }
    else{
      header('Location: index.php');
    }
    $logged = isset($_SESSION['UserData']);
  }
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
    <title>Sylwetka Boga 2018</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg fixed-top">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span><i class="fas fa-bars"></i></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav" style="width:100%; display:flex; justify-content: center;">
          <li class="nav-item">
            <a class="nav-link" href="./index.php">Główna<span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <?php
             if(!$logged) echo "<span id='loginTrigger' class='nav-link'>Zaloguj<i class='fas fa-sign-in-alt'></i></span>";
             else{echo "<span class='nav-link' id='add-post'>Dodaj trening</span></li>";
                  echo "<li class='nav-item'><a href='scripts/server/logout.php' class='nav-link'>Wyloguj <i class='fas fa-sign-out-alt'></i></a></li>";}?>
          </li>
        </ul>
      </div>
    </nav>
    <div style="margin-top: 80px;">
      <?php
      $post = $chosenPost;
      $result = $connection->query("SELECT * FROM comments WHERE Post_ID = {$post['ID']}");

        echo '<div class="post" style="margin: auto; margin-bottom: 10px;">
          <a class="post-link" href="post.php?id='.$post['ID'].'">'.$post['Date'].'</a>
          <img src="img/characters/'.strtolower($post['Owner']).'/main.jpg" alt="Imie">
          <h3>'.$post['Owner'].'</h3>
          <div>
               <p>Typ treningu <br> <span>'.$post['Type'].'</span> </p>
               <p>Czas <br> <span>'.$post['Time_min'].'</span> </p>
           </div>
           <p class="post-description">'.$post['Description'].'
           <br><img class="thumb" src="img/like.png"><span>'.$post["Likes"].'</span></p>
           <form action="scripts/server/addComment.php" method="post">
             <h6 opened="false">Comments <i class="fas fa-angle-down"></i> </h6>
             <div class="comment-addition">
              <div class="comment-left-box">
                <input type="text" name="name" value="';
        if($logged) echo $_SESSION['UserData']['nick'];
        echo '" class="';
        if($logged) echo "disabled-nick";
        echo '" required>
        <input type="submit" value="Dodaj">
      </div>
       <textarea name="content" required></textarea>
     </div>
     <input name="postID" value="'.$post['ID'].'"></input>
     </form>
     <div class="comments">
       <div class="inner-comments">';
       if ($result ->num_rows >0) {
       while ($row = $result->fetch_assoc()){
           if ($row['Is_Verified']) $Verified = 'verified';
           else $Verified = '';
           echo "<div class='comment'><p class='comment-content'><span class='comment-name' title='".$row['Comment_Date']."'".$Verified.">".$row['Name']."</span>".$row['Content']."</p><div><img class='thumb' src ='img/like.png'><span>".$row['Likes']."</span><data value = '".$row['Comments_ID']."'></data></div></div>";
         }
       }
       echo '</div>
      </div>
 </div>';
     ?>
   </div>
    <div id="logForm">
      <?php
       if(!$logged) echo "<button id='loginTrigger'><i class='fas fa-sign-in-alt'></i></button>";
       else{echo "<span class='logged-option' id = 'add-post'>Dodaj trening</span>";
            echo "<a href='scripts/server/logout.php' class='logged-option'>Wyloguj</a>";}?>
      <form  action="scripts/server/login.php" method="post">
          <p>Nick</p>
          <input type="text" name="nick">
          <p>Hasło</p>
          <input type="password" name="password">
          <input type="submit" value="Zaloguj">
      </form>
    </div>
    <data value="<?php if($logged) echo '1' ?>"></data>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script src="scripts/main.js"></script>
  </body>
</html>
