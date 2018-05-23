<?php session_start();
  require_once"scripts/server/connect.php";
  $connection = @new mysqli($host, $db_user, $db_password, $db_name);
  if ($connection->connect_errno!=0) {
    echo "Error: ".$connection->connect_errno; exit();
  }
  else{
    $_SESSION['location'] = '';
    $result = $connection->query("SELECT ID, nick , workout_num , workout_time FROM users");
    if ($result ->num_rows >0) {
      $totalTime = 0;
      $totalWorkouts = 0;
      $users = array();
      while ($row = $result->fetch_assoc()) {
        $totalTime += $row["workout_time"];
        $totalWorkouts += $row["workout_num"];
        array_push($users, $row);
      }
      shuffle($users);
    }

    $result = $connection->query("SELECT * FROM workouts ORDER BY ID DESC LIMIT 4");
      $newPosts = array();
      while ($row = $result->fetch_assoc()){
        array_push($newPosts, $row);
      }
  }
  $logged = isset($_SESSION['UserData']);
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
                  echo "<li class='nav-item'><a href='scripts/server/logout.php' class='nav-link'>Wyloguj <i class='fas fa-sign-out-alt'></i></a></li>";
                  echo "<li class='nav-item'><a href='profil.php' class='nav-link'>Profil</a></li>";}?>
          </li>
        </ul>
      </div>
    </nav>
    <div id="landing">
      <h2>Wykonanych treningów</h2>
      <h1><?php echo $totalWorkouts; ?></h1>
      <h2>Przećwiczonych minut</h2>
      <h1><?php echo $totalTime; ?></h1>
      <div class="stats" id="workoutAmount">
        <p>Liczba treningów</p>
          <div class="single-data" value = <?php echo $users[0]["workout_num"] ?>>
            <span></span>
            <p><?php echo $users[0]["nick"] ?></p>
          </div>
          <div class="single-data" value = <?php echo $users[1]["workout_num"] ?>>
            <span></span>
            <p><?php echo $users[1]["nick"] ?></p>
          </div>
          <div class="single-data" value = <?php echo $users[2]["workout_num"] ?>>
            <span></span>
            <p><?php echo $users[2]["nick"] ?></p>
          </div>
          <div class="single-data" value = <?php echo $users[3]["workout_num"] ?>>
            <span></span>
            <p><?php echo $users[3]["nick"] ?></p>
          </div>
          <div class="single-data" value = <?php echo $users[4]["workout_num"] ?>>
            <span></span>
            <p><?php echo $users[4]["nick"] ?></p>
          </div>
          <div class="single-data" value = <?php echo $users[5]["workout_num"] ?>>
            <span></span>
            <p><?php echo $users[5]["nick"] ?></p>
          </div>
          <div class="single-data" value = <?php echo $users[6]["workout_num"] ?>>
            <span></span>
            <p><?php echo $users[6]["nick"] ?></p>
          </div>
          <div class="single-data" value = <?php echo $users[7]["workout_num"] ?>>
            <span></span>
            <p><?php echo $users[7]["nick"] ?></p>
          </div>
          <div class="single-data" value = <?php echo $users[8]["workout_num"] ?>>
            <span></span>
            <p><?php echo $users[8]["nick"] ?></p>
          </div>
      </div>

    <div class="stats" id="timeSpent">
      <p>Czas treningów</p>
      <div class="single-data" value = <?php echo $users[0]["workout_time"] ?>>
        <span></span>
        <p><?php echo $users[0]["nick"] ?></p>
      </div>
      <div class="single-data" value = <?php echo $users[1]["workout_time"] ?>>
        <span></span>
        <p><?php echo $users[1]["nick"] ?></p>
      </div>
      <div class="single-data" value = <?php echo $users[2]["workout_time"] ?>>
        <span></span>
        <p><?php echo $users[2]["nick"] ?></p>
      </div>
      <div class="single-data" value = <?php echo $users[3]["workout_time"] ?>>
        <span></span>
        <p><?php echo $users[3]["nick"] ?></p>
      </div>
      <div class="single-data" value = <?php echo $users[4]["workout_time"] ?>>
        <span></span>
        <p><?php echo $users[4]["nick"] ?></p>
      </div>
      <div class="single-data" value = <?php echo $users[5]["workout_time"] ?>>
        <span></span>
        <p><?php echo $users[5]["nick"] ?></p>
      </div>
      <div class="single-data" value = <?php echo $users[6]["workout_time"] ?>>
        <span></span>
        <p><?php echo $users[6]["nick"] ?></p>
      </div>
      <div class="single-data" value = <?php echo $users[7]["workout_time"] ?>>
        <span></span>
        <p><?php echo $users[7]["nick"] ?></p>
      </div>
      <div class="single-data" value = <?php echo $users[8]["workout_time"] ?>>
        <span></span>
        <p><?php echo $users[8]["nick"] ?></p>
      </div>
    </div>
<button id="show-profiles" type="button" opened="false">Lista Kadetów<i class="fas fa-angle-down toggle-arrow"></i></button>
<div id="profiles">
  <div id="inner-profiles">
    <div id="scroll-box">
  <?php
    for ($i=0; $i < sizeof($users); $i++) {
      if($users[$i]["workout_num"]>0){
        $name = strtolower($users[$i]["nick"]);
        echo '<a href = "profile.php?id='.$users[$i]["ID"].'" title="'.$users[$i]["nick"].'"><img src="img/characters/'.$name.'/main.jpg" alt="'.$users[$i]["nick"].'"></a>';
      }
    }
   ?>
      </div>
   </div>
</div>
    <div id="latest-workouts">
      <?php
      for ($i = 0; $i <sizeof($newPosts); $i++){
        $post = $newPosts[$i];
        $result = $connection->query("SELECT * FROM comments WHERE Post_ID = {$post['ID']}");

          echo '<div class="post">
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
   }
       ?>

    </div>
    </div>
      <form id="logForm"  action="scripts/server/login.php" method="post">
          <span id = 'close'>X</span>
          <p>Nick</p>
          <input type="text" name="nick" required>
          <p>Hasło</p>
          <input type="password" name="password" required>
          <input type="submit" value="Zaloguj">
      </form>
    <data value="<?php if($logged) echo '1' ?>"></data>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script src="scripts/main.js"></script>
  </body>
</html>
