<?php

// Database connection
$hostname = "localhost";
$username = "root";
$password = "J@mes123";
$db = "capstone_db";
$conn = new mysqli($hostname, $username, $password, $db) or die("Connect failed: %s\n". $conn -> error);

?>
