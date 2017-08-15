<?php
 require_once ('../includes/connections.php');
 require_once ('../includes/header.php');
 require_once ('../includes/functions.php');

 $nameError = "";
 $ageError = "";
 $emailError = "";
 $passwordError = "";
 if (isset($_POST['add'])){

        //set all variables empty by dafault
        $name = $age = $email = $password = "";
       

        //check to see if the inputs are empty
        //create variables with form data
        //wrap the data with our function

        if (!$_POST["name"]){
            $nameError = "please enter a name<br>";
        } else {
            $name = validateFormData ($_POST["name"]);
        }
        if (!$_POST["age"]){
            $ageError = "please enter your age<br>";
        } else {
            $age = validateFormData ($_POST["age"]);
        }
        if (!$_POST["email"]){
            $emailError = "please enter your email<br>";
        } else {
            $email = validateFormData ($_POST["email"]);
        }
        if (!$_POST["password"]){
            $passwordError = "please enter your age<br>";
        } else {
            $password = validateFormData($_POST["password"]);
             $hashedPass = password_hash($password, PASSWORD_DEFAULT);
        }

         $trueage = $age;
        if ($trueage < 18) {
          echo "<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>You are Under aged! </div>"; 
        } else {

        //if required fields have data
        if ($name && $age && $email && $password){

            //create query
            $query = "INSERT INTO users (id, name, age, email, password, created_at)
             VALUES (NULL, '$name', '$age', '$email', '$hashedPass',CURRENT_TIMESTAMP)";
            
            $result = mysqli_query ($conn, $query);

            //if query was successful
            if ($result){
                // refresh page with query string
              echo "<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>New record in database!</div>";
                header('Location:login.php');
            } else {
                //something went wrong
                echo "Error: ". $query ."<br>" . mysqli_error($conn);
            }
        }
      }
 }
 ?>
     
      <nav class="navbar navbar-default navbar-inverse" id=bs-navbar>
  <!--<div class="container-fluid">-->
  <div class="navbar-header">
    <a class="navbar-brand" href="#">THREADED</a>
  </div>
  <ul class="nav navbar-nav navbar-right">
      <li><a href="../logic/login.php">LOGIN</a></li>
    </ul>
    </nav>
    </div> <!--container end-->

    <form class="form-signin action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <label for="inputName">Name</label>
        <input type="text" id="inputName" class="form-control" name="name" placeholder="Name" required autofocus>
        <label for="inputAge">Age</label>
        <input type="number" id="inputAge" class="form-control" name="age" placeholder="Age" required>
        <label for="inputEmail">Email address</label>
        <input type="email" id="inputEmail" class="form-control" name="email" placeholder="Email address" required>
        <label for="inputPassword">Password</label>
        <input type="password" id="inputPassword" class="form-control" name="password" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="add">REGISTER</button>
    </form>
     <?php
     require_once ('../includes/footer.php');
     
     ?>