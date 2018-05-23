<?php session_start();
  require_once"scripts/server/connect.php";
  $connection = @new mysqli($host, $db_user, $db_password, $db_name);
  if ($connection->connect_errno!=0) {
    echo "Error: ".$connection->connect_errno; exit();
  }

  else{
    $userId = htmlentities($_GET['id'], ENT_QUOTES, "UTF-8");
    $_SESSION['location'] = 'profile.php?id='.$userId;
    $result = $connection->query("SELECT nick , workout_num , workout_time, bio FROM users WHERE ID = $userId");
    if ($result ->num_rows >0) {
      $chosenUser = $result->fetch_assoc();
    }
    else{
      header('Location: index.php');
    }

    $result = $connection->query("SELECT workout_num , workout_time FROM users ORDER BY workout_num DESC");
    if ($result ->num_rows >0) {
      $positionNumCounter = 1;
      $positionTimeCounter = 1;
      $wokoutsArray = array();
      while($row = $result->fetch_assoc()){
        if($row['workout_num'] > $chosenUser['workout_num']) $positionNumCounter++;
        array_push($wokoutsArray, $row['workout_time']);
      }
      rsort($wokoutsArray);
      for ($i=0; $i<sizeof($wokoutsArray); $i++) {
        if($wokoutsArray[$i] <= $chosenUser['workout_time']) {break;}
        $positionTimeCounter++;
      }
    }
    $result = $connection->query("SELECT * FROM workouts WHERE Owner_ID = $userId ORDER BY ID DESC");
    $userPosts = array();
    if ($result ->num_rows >0) {
      while($row = $result->fetch_assoc()){
        array_push($userPosts, $row);
      }
    }

    $result = $connection->query("SELECT Likes FROM comments WHERE Name = '{$chosenUser['nick']}' AND Is_Verified = 1");
    $userComments = array();
    if ($result ->num_rows >0) {
      while($row = $result->fetch_assoc()){
        array_push($userComments, $row);
      }
    }
  }
  $logged = isset($_SESSION['UserData']);

  //get the most picked excercise
  if(sizeof($userPosts)>0){
      $typeApperances = array(0, 0, 0, 0, 0);
      for ($i=0; $i<sizeof($userPosts) ; $i++) {
          switch($userPosts[$i]['Type']){
            case "Split":
                $typeApperances[0]++;
                break;
            case "FBW":
                $typeApperances[1]++;
                break;
            case "Kalistenika":
                $typeApperances[2]++;
                break;
            case "Cardio":
                $typeApperances[3]++;
                break;
            case "Inne":
                $typeApperances[4]++;
                break;
            default:
          }
      }
      $max = array_keys($typeApperances, max($typeApperances));
      if($max[0] == 0) $mostPickedType = "Split";
      else if($max[0] == 1) $mostPickedType = "FBW";
      else if($max[0] == 2) $mostPickedType = "Kalistenika";
      else if($max[0] == 3) $mostPickedType = "Cardio";
      else if($max[0] == 4) $mostPickedType = "Inne";
  }

  else $mostPickedType = "Żaden";
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
    <main>
      <img src="img/characters/<?php echo strtolower($chosenUser['nick'])?>/main.jpg" alt="User Photo">
          <h1><?php echo $chosenUser['nick']; ?></h1>
          <p id="bio"><?php echo $chosenUser['bio']; ?></p>
      <div id="user-stats">
          <div class="stat">
            <h3>Treningów</h3>
            <span><?php echo $chosenUser['workout_num'].' (#'.$positionNumCounter.')';?></span>
          </div>
          <div class="stat">
            <h3>Minut na treningu</h3>
            <span><?php echo $chosenUser['workout_time'].' (#'.$positionTimeCounter.')' ?></span>
          </div>
          <div class="stat">
            <h3>Średni czas treningu</h3>
            <span><?php if(sizeof($userPosts)>0) echo round($chosenUser['workout_time']/$chosenUser['workout_num']); else echo "0"; ?></span>
          </div>
          <div class="stat">
            <h3>Ulubiony trening</h3>
            <span><?php echo $mostPickedType; ?></span>
          </div>
          <div class="stat">
            <h3>Data ostatniego treningu</h3>
            <span><?php if(sizeof($userPosts)>0)echo $userPosts[0]['Date']; else echo "Nigdy";?></span>
          </div>
          <div class="stat">
            <h3>Komentarze</h3>
            <span><?php echo sizeof($userComments) ?></span>
          </div>
      </div>
    </main>
    <div id="latest-workouts">
        <?php
        for ($i = 0; $i <sizeof($userPosts); $i++){
          $post = $userPosts[$i];
          $result = $connection->query("SELECT * FROM comments WHERE Post_ID = {$post['ID']}");
            echo '<div class="post">
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
        <p class="post-date">'.$post['Date'].'</p>
     </div>';
     }
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
