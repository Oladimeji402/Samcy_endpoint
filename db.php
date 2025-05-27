<?php
$host = "localhost";
$username = "root"; 
$password = "";     
$database = "Samcy_v1.01";


$conn = new mysqli($host, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
