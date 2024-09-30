<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "line_bot";

$conn = mysqli_connect($servername, $username, $password, $db);
mysqli_set_charset($conn,"utf8");

if( $conn === false ) {
    die("Connection failed: " . mysqli_connect_error());
    exit;
}


?>