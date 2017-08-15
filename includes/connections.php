<?php 

$server ="localhost";
$username="root";
$password="church182";
$db ="db_threaded";
// create a connection
$conn = mysqli_connect($server, $username, $password, $db);

//check connection
if (!$conn){
    die("connection failed: " . mysqli_connect_error());
}
//echo "connected successfully!";
?>