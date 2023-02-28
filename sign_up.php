<?php
session_start();
  include "db_connect.php";
  include "functions.php";

  if($_SERVER["REQUEST_METHOD"] == "POST"){
    // something was posted
    // Collect information from form
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['pword'];
    $grad_year = $_POST['grad_year'];
    $major_1 = $_POST['major_1'];
    $major_2 = $_POST['major_2'];
    $minor_1 = $_POST['minor_1'];
    $minor_2 = $_POST['minor_2'];
    $job = $_POST['job'];

    if(!empty($firstname) && !empty($lastname) && !empty($email) && !empty($password)){
        // save to database
        $user_id = random_num(10);
        $sql = "insert into alumni (user_id,first_name,last_name,email,pword,grad_year,major_1,major_2,minor_1,minor_2,job)
        values('$user_id', '$firstname', '$lastname', '$email', '$password', '$grad_year', '$major_1', '$major_2', '$minor_1', '$minor_2', '$job')";
        mysqli_query($conn, $sql);
        echo "Sign Up was successful";
        header("Location: login.php");
        die();

    }else{
        echo "Please enter some valid information";
    }
    
  }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sign Up Page</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Sign Up Page</h2>
<br>
<form action="">
    <label for="fname">First Name:</label>
    <input type="text" name="fname" id="fname"><br><br>

    <label for="lname">Last Name:</label>
    <input type="text" name="lname" id="lname"><br><br>

    <label for="email">Email:</label>
    <input type="email" name="email" id="email"><br><br>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password">

    <label for=""></label>


    <input type="submit" value="Sign Up">
</form>
</body>
</html>