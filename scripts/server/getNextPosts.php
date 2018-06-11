<?php session_start();
  require_once"connect.php";
  if(!isset($_POST['lastPostIndex'])) exit();
  $logged = isset($_SESSION['UserData']);
  $connection = @new mysqli($host, $db_user, $db_password, $db_name);
  if ($connection->connect_errno!=0) {
    echo "Error: ".$connection->connect_errno; exit();
  }
  else{
    $post_limit = $_POST['lastPostIndex']+4;
    $result = $connection->query("SELECT * FROM workouts ORDER BY ID DESC LIMIT {$post_limit}");
      $newPosts = array();
      while ($row = $result->fetch_assoc()){
        array_push($newPosts, $row);
      }

      for ($i = 0; $i <sizeof($newPosts); $i++){
        $post = $newPosts[$i];
        $result = $connection->query("SELECT * FROM comments WHERE Post_ID = {$post['ID']}");

          echo '<div class="post">';
            if ($logged && $post['Owner_ID'] == $_SESSION['UserData']['ID']) {
              echo '<div class= "settings-trigger-box"><i class="fas fa-cog post-settings-trigger"></i></div>';
             }
          echo '<a class="post-link" href="post.php?id='.$post['ID'].'">'.$post['Date'].'</a>
            <img src="img/characters/'.strtolower($post['Owner']).'/main.jpg" alt="Imie">
            <a class="post-owner-link" href="profile.php?id='.$post['Owner_ID'].'">'.$post['Owner'].'</a>
            <div class = "post-stat-box">
                 <p>Typ treningu <br> <span class = "post-stat-type">'.$post['Type'].'</span> </p>
                 <p>Czas <br> <span class = "post-stat-time">'.$post['Time_min'].'</span> </p>
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
  }

 ?>
