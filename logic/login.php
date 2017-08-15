
<?php
 session_start();
 require_once ('../includes/connections.php');
 require_once ('../includes/header.php');
 require_once ('../includes/functions.php'); 

 $loginError = "";

  if (isset($_POST['login'])){
        //create variables
        // wrap data with validate function
        $formEmail = validateFormData($_POST['email']);
        $formPass = validateFormData($_POST['password']);


         //create query
         $query = "SELECT * FROM users WHERE email='$formEmail'";

         //store the result
         $result = mysqli_query($conn, $query);

         //verify if result is returned
         if (mysqli_num_rows ($result) > 0){
             //store basic user data in variables
             while ($row = mysqli_fetch_assoc($result)){
                 $email = $row['email'];
                 $hashedPass = $row['password'];
                 $user_id = $row['id'];

             }
             // echo $formPass;
             // echo "<br>";
             // echo $hashedPass;
             // echo "<br>";
             // var_dump(password_verify($formPass, $hashedPass));
             // die();
             if (password_verify($formPass, $hashedPass)){
                 //correct login details
                 //store data in session variables
                   

                 $_SESSION['loggedin'] = 1;
                 $_SESSION['user_id'] = $user_id;


                 //redirect user to interns page
                 header ("Location:../index.php");
             } else {//hashed password didn't verify
                //error message
                $loginError = "<div class='alert alert-danger'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Wrong username / password combination. Try again. </div>";

             }
         } else {//there are no results in database
            //error message
                $loginError = "<div class='alert alert-danger'>Wrong username / password combination. Try again. 
                <a class='close' data-dismiss='alert'>&times;</a></div>";
         }

    }

 ?>
     
   <nav class="navbar navbar-default navbar-inverse" id=bs-navbar>
  <!--<div class="container-fluid">-->
  <div class="navbar-header">
    <a class="navbar-brand" href="#">THREADED</a>
  </div>
  <ul class="nav navbar-nav navbar-right">
      <li><a href="../logic/register.php">REGISTER</a></li>
    </ul>
    </nav>
  <div class="container">

      <form class="form-signin" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <h2 class="form-signin-heading">Please sign in</h2>
        <p><?php echo $loginError; ?> </p>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" class="form-control" placeholder="Email address" name="email" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="login">Sign in</button>
      </form>

    </div> <!-- /container -->
    <?php
     require_once ('../includes/footer.php');
     
     ?>
