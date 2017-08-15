<?php
  SESSION_START();
   
 require_once ('../includes/connections.php');
  if (!isset ($_SESSION['loggedin']) || ($_SESSION ['loggedin'] != 1)){
        header('Location:login.php');
    } else{
        $id = $_GET['id'];
        $user_id = $_SESSION['user_id'];
        $query = "SELECT * FROM threads WHERE id = $id";
        $result = mysqli_query($conn, $query);
        $echo = mysqli_fetch_assoc($result);
        $displayTopic = $echo['title'];
    }

    if(isset($_POST['send'])){
      $comments = $_POST['comments'];
      $sql = "INSERT into comments(user_id, thread_id, comments)
      VALUES('$user_id', '$id', '$comments' )";  
        if (mysqli_query($conn, $sql)) {
            echo "<p class = 'text-success'>New comment added!</p>";
            // header('Location:topics.php');
            
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }
    } 

    $rail = "SELECT users.name, comments.comments, comments.created_at FROM comments INNER JOIN users on users.id= comments.user_id WHERE comments.thread_id=$id";
    $result = mysqli_query($conn, $rail);

 require_once ('../includes/header.php');

 ?>
        
        <div class="container">
            <span class="nav navbar-nav navbar-right"><a href="logout.php"><button class="btn btn-success">LOGOUT</button></a></span><br><br>
            <div class="jumbotron text-center">
                <h2>Title of Thread</h2>
                <p><?php echo (ucwords($displayTopic)); ?></p>
            </div>
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2">
                    <div class="content">
<?php

  while ($row = mysqli_fetch_assoc($result)) {
    echo '<div class="media">';
    echo '<div class="media-left">';
    echo '<img src="../assests/Images/avatars.jpg" class="media-object" style="width:60px">';
    echo '</div>';
    echo '<div class="media-body">';
    echo '<h4 class="media-heading">'. $row['name'] .' <span class="pull-right">'.$row['created_at'].'</span></h4>';
    echo '<p>'.$row['comments'].'</p>';
    echo '</div></div><br><hr><br>';
  }

?>
                </div>
                    <form method="post">
                        <div class="input-group">
                            <input type="text" class="form-control" id="text" placeholder="Write here" name="comments">
                            <span class="input-group-btn">
                            <button class="btn btn-success" name="send">Send</button>
                            </span>
                        </div>
                </form>
                </div>
                
            </div>

      </div>
         <?php
           mysqli_close($conn);
          ?>
    </body>
</html>