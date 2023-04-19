<?php
// // Database connection
// $hostname = "localhost";
// $username = "root";
// $password = "";
// $db = "capstone_db";
// $conn = new mysqli($hostname, $username, $password, $db) or die("Connect failed: %s\n". $conn -> error);

$hostname = "localhost";  // database host
$username = "root"; // initial username
$password = ""; // initial password
$db = "capstone_db"; // database name

// create mysqli object and connect to database
$conn = new mysqli($hostname, $username, $password, $db);

// check connection
if ($conn->connect_error) {
    // connection failed, try new username and password
    $username = "u230170949_root"; // new username
    $password = "J@mes123"; // new password
    $db = "u230170949_capstone_db"; // new DB
    
    // create new mysqli object and connect to database with new username and password
    $conn = new mysqli($hostname, $username, $password, $db);
    
    // check new connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        echo "Connected successfully with new username and password";
    }
} else {
    echo "Connected successfully with initial username and password";
}
?>