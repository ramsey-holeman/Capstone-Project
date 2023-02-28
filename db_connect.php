<?php

// Database connection
$hostname = "localhost";
$username = "root";
$password = "";
$db = "alumni_reach";
$conn = new mysqli($hostname, $username, $password, $db) or die("Connect failed: %s\n". $conn -> error);

?>