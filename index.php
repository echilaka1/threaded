<?php
    SESSION_START();
     require_once ('includes/connections.php');
    if (!isset ($_SESSION['loggedin']) || ($_SESSION ['loggedin'] != 1)){
        header('Location:logic/login.php');
    }
// var_dump($_SESSION);
// exit();
    $status = false;
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM threads";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0){ 
        $status = true;
    }
    if(isset($_POST['send'])){
    $topic = $_POST['topic'];
    $query = "INSERT into threads (user_id, title)
    VALUES('$user_id', '$topic')";
    
        if (mysqli_query($conn, $query)) {
            echo "<p class = 'text-success'>New Topic created successfully !</p>";
            header('Location:index.php');
            
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }

}    
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Threads</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="assests/bootstrap/dist/css/bootstrap.min.css">
    
    </head>

    <body>
    <header>
        <div class="container-fluid">
        <nav class="navbar navbar-inverse">
           <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand" href="#">Threaded</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <!-- <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                  <ul class="nav navbar-nav navbar-right">
                    <li class="active"><a href="#">Sign Up<span class="sr-only">(current)</span></a></li>
                    <li><a href="login.php">Login</a></li>
                  </ul>
                </div>/.navbar-collapse --> 
              </div><!-- /.container-fluid -->
        </nav>
        </div>
    </header>

        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add New Topic</h4>
              </div>
              <div class="modal-body">
                <form method="post">
                        <div class="input-group">
                            <input type="text" class="form-control" id="text" placeholder="Write here" name="topic">
                            <span class="input-group-btn">
                            <button class="btn btn-success" name="send">Add</button>
                            </span>
                        </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>


          </div>
        </div>
        
            <div id="myMod" class="modal fade" role="dialog">
              <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Topic</h4>
                  </div>
                  <div class="modal-body">
                    <form method="post">
                            <div class="input-group">
                                <input type="text" class="form-control" id="text" placeholder="Write here" name="edit_topic">
                                <span class="input-group-btn">
                                <button class="btn btn-success" name="update">Edit</button>
                                </span>
                            </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>
            

          </div>
        </div> 

        
        <div class="container">
            <span class="nav navbar-nav navbar-right"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">ADD TOPIC</button><a href="logic/logout.php"><button class="btn btn-success">LOGOUT</button></a></span><br><br>
            <br>
        
       

        <h1>Trending Topics</h1>
        

        <?php
           
            if ($status == false){
                echo "<p>There are no topics yet</p>";
            }else{
                while($row = mysqli_fetch_assoc($result)){
                    if ($row['user_id'] == $_SESSION['user_id']){
                        
                  echo '<div class="input-group">';
                  echo '<a href="logic/topics.php?id='.$row['id'].'" class="list-group-item form-control">'. $row['title'].'</a> <span class="input-group-btn"><button class="btn btn-primary btn btn-info glyphicon glyphicon-edit" data-toggle="modal" data-target="#myMod">
              </button></span>';
              

                  
                    // echo '<p><a href=</a></p>';
                    
                    echo '</div>';
                    echo '<br><br>';
                    } else if ($row['user_id'] != $_SESSION['user_id']){
                        echo ('<div> <a href="logic/topics.php?id='.$row['id'].'" class="list-group-item">'. $row['title'].'</a></div>');
                        echo '<br><br>';
                    }
                }
            }
            ?>
   
    </div>
    <?php
      mysqli_close($conn);
    ?>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="assests/bootstrap/dist/js/jquery-3.2.1.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="assests/bootstrap/dist/js/bootstrap.min.js"></script>
  </body>
  </html>