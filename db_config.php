<?php
$host = "localhost";  // or your hosting DB server
$user = "your_db_username";
$password = "your_db_password";
$database = "your_database_name";

$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
