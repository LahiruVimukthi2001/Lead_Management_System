<?php 
// DB credentials.
$localhost = "localhost";
$username = "root";
$password = "";
$dbname = "penglead";

// db connection
$connect = new mysqli($localhost, $username, $password, $dbname);

// check connection
if($connect->connect_error) {
  die("Database Connection Failed : " . $connect->connect_error);
} else {
  // echo "Database Successfully connected";
}
?>





