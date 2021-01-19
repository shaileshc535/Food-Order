<?php 

    //start session
    session_start();


$SITEURL = "http://localhost/food-order/";
$server = "localhost";
$username = "root";
$password = "";
$database = "food-order";

$conn = mysqli_connect($server, $username, $password, $database);
?>