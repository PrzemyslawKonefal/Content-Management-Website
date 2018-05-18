<?php session_start();
  require_once"scripts/server/connect.php";
  $connection = @new mysqli($host, $db_user, $db_password, $db_name);
  if ($connection->connect_errno!=0) {
    echo "Error: ".$connection->connect_errno; exit();
  }
  else{
    $result = $connection->query("SELECT nick , workout_num , workout_time FROM users");
    if ($result ->num_rows >0) {
      $totalTime = 0;
      $totalWorkouts = 0;
      $users = array();
      while ($row = $result->fetch_assoc()) {
        $totalTime += $row["workout_time"];
        $totalWorkouts += $row["workout_num"];
        array_push($users, $row);
      }
    }

    $result = $connection->query("SELECT * FROM workouts ORDER BY ID DESC LIMIT 3");
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
    <title>Sylwetka marzeń 2018</title>
  </head>
  <body>
    <div id="landing">
      <h2>Wykonanych treningów</h2>
      <h1><?php echo $totalWorkouts; ?></h1>
      <h2>Przećwiczonych minut</h2>
      <h1><?php echo $totalTime; ?></h1>
      <div class="stats" id="workoutAmount">
        <p>Liczba treningów</p>

          <div class="single-data" value = <?php echo $users[0]["workout_num"] ?>>
            <span></span>
            <p>K</p>
          </div>
          <div class="single-data" value = <?php echo $users[1]["workout_num"] ?>>
            <span></span>
            <p>W</p>
          </div>
          <div class="single-data" value = <?php echo $users[2]["workout_num"] ?>>
            <span></span>
            <p>DO</p>
          </div>
          <div class="single-data" value = <?php echo $users[3]["workout_num"] ?>>
            <span></span>
            <p>DD</p>
          </div>
          <div class="single-data" value = <?php echo $users[4]["workout_num"] ?>>
            <span></span>
            <p>R</p>
          </div>
          <div class="single-data" value = <?php echo $users[5]["workout_num"] ?>>
            <span></span>
            <p>J</p>
          </div>
          <div class="single-data" value = <?php echo $users[6]["workout_num"] ?>>
            <span></span>
            <p>P</p>
          </div>
          <div class="single-data" value = <?php echo $users[7]["workout_num"] ?>>
            <span></span>
            <p>B</p>
          </div>
          <div class="single-data" value = <?php echo $users[8]["workout_time"] ?>>
            <span></span>
            <p>M</p>
          </div>
      </div>
    </div>
    <div class="stats" id="timeSpent">
      <p>Czas treningów</p>

        <div class="single-data" value = <?php echo $users[0]["workout_time"] ?>>
          <span></span>
          <p>K</p>
        </div>
        <div class="single-data" value = <?php echo $users[1]["workout_time"] ?>>
          <span></span>
          <p>W</p>
        </div>
        <div class="single-data" value = <?php echo $users[2]["workout_time"] ?>>
          <span></span>
          <p>DO</p>
        </div>
        <div class="single-data" value = <?php echo $users[3]["workout_time"] ?>>
          <span></span>
          <p>DD</p>
        </div>
        <div class="single-data" value = <?php echo $users[4]["workout_time"] ?>>
          <span></span>
          <p>R</p>
        </div>
        <div class="single-data" value = <?php echo $users[5]["workout_time"] ?>>
          <span></span>
          <p>J</p>
        </div>
        <div class="single-data" value = <?php echo $users[6]["workout_time"] ?>>
          <span></span>
          <p>P</p>
        </div>
        <div class="single-data" value = <?php echo $users[7]["workout_time"] ?>>
          <span></span>
          <p>B</p>
        </div>
        <div class="single-data" value = <?php echo $users[8]["workout_time"] ?>>
          <span></span>
          <p>M</p>
        </div>
    </div>
    <div id="latest-workouts">
      <div class="post">
        <img src="" alt="Imie">
        <h3><?php echo $newPosts[0]['Owner'] ?></h3>
        <div>
             <p>Typ treningu <br> <span><?php echo $newPosts[0]['Type']; ?></span> </p>
             <p>Czas <br> <span><?php echo $newPosts[0]['Time_min'] ?></span> </p>
         </div>
         <p> <?php echo $newPosts[0]['Description']; ?></p>
         <p> <?php echo $newPosts[0]['Date'] ?> </p>
      </div>

      <div class="post">
        <img src="" alt="Imie">
        <h3><?php echo $newPosts[1]['Owner'] ?></h3>
        <div>
             <p>Typ treningu <br> <span><?php echo $newPosts[1]['Type']; ?></span> </p>
             <p>Czas <br> <span><?php echo $newPosts[1]['Time_min'] ?></span> </p>
         </div>
         <p> <?php echo $newPosts[1]['Description']; ?></p>
         <p> <?php echo $newPosts[1]['Date'] ?> </p>
      </div>

      <div class="post">
        <img src="" alt="Imie">
        <h3><?php echo $newPosts[2]['Owner'] ?></h3>
        <div>
             <p>Typ treningu <br> <span><?php echo $newPosts[2]['Type']; ?></span> </p>
             <p>Czas <br> <span><?php echo $newPosts[2]['Time_min'] ?></span> </p>
         </div>
         <p> <?php echo $newPosts[2]['Description']; ?></p>
         <p> <?php echo $newPosts[2]['Date'] ?> </p>
      </div>
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
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script src="scripts/main.js"></script>
  </body>
</html>
