<?php session_start();
  if (!isset($_SESSION['UserData'])) {header("Location: index.php"); exit();}
  $logged = true;
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

      <div id="option-box">
          <?php
          if (isset($_SESSION['passChanged'])) {
            echo "<h1 style = 'color:green; text-align: center;'>Hasło zostało zmienione</h1>";
            unset($_SESSION['passChanged']);
          }
          elseif(isset($_SESSION['bioChanged'])) {
            echo "<h1 style = 'color:green; text-align: center;'>Bio zostało zmienione</h1>";
            unset($_SESSION['bioChanged']);
          }
          elseif(isset($_SESSION['pass_Err'])){
            echo $_SESSION['pass_Err'];
            unset($_SESSION['pass_Err']);
          }
          ?>
          <form class="profile-change" action="scripts/server/changePass.php" method="post">
            <h3>Zmiana hasła</h3>
            <div>
            <p>Stare hasło</p>
            <input type="password" name="passOld" value="" required>
            </div>
            <div>
            <p>Nowe hasło</p>
            <input type="password" name="passNew" value="" required>
            </div>
            <div>
            <p>Powtórz nowe hasło</p>
            <input type="password" name="passNew2" value="" required>
            </div>
            <input type="submit" value="Zmień">
          </form>

          <form class="profile-change" action="scripts/server/changeBio.php" method="post">
            <h3>Bio profilu</h3>
            <textarea name="bio"><?php echo $_SESSION['UserData']['bio']; ?></textarea>
            <input type="submit" value="Zmień" required>
          </form>
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
