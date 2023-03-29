<?php
session_start();
  include "db_connect.php";
  include "functions.php";

  if($_SERVER["REQUEST_METHOD"] == "POST"){
    // something was posted
    // Collect information from form
    $firstname = $_POST['fname'];
    $lastname = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['pword'];

    if(!empty($firstname) && !empty($lastname) && !empty($email) && !empty($password)){
        // save to database
        $user_id = random_num(10);
        $sql = "insert into users (user_id,first_name,last_name,email,pword) values('$user_id', '$firstname', '$lastname', '$email', '$password')";
        mysqli_query($conn, $sql);
        echo "Sign Up was successful";
        header("Location: login_page.php");
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
  <!-- <link rel="stylesheet" href="style.css"> -->
  <link rel="stylesheet" href="normalize.css">
  <link rel="stylesheet" href="skeleton.css">
  <div id="wrap">
      <nav>
          <ul class="navbar">
              <a href="index.php">Dashboard</a>
              <a href="portfolio_edit.php">Edit Portfolio</a>
              <a href="options.php">Stock Options Positions</a>
              <a href="login_page.php">Login</a><br>
              <a href="logout.php">Logout</a>
          </ul>
      </nav>
  </div>  
</head>
<body>
<h2 style="text-align: center;">Sign Up Page</h2>
<br>
<div>
  <form action="" method="post" autocomplete="off" style="text-align: center">
    <label for="fname">First Name:</label>
    <input type="text" name="fname" id="fname" required><br><br>

    <label for="lname">Last Name:</label>
    <input type="text" name="lname" id="lname" required><br><br>

    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required><br><br>

    <label for="pword">Password:</label>
    <input type="password" name="pword" id="pword" required><br><br>

    <input type="submit" value="Sign Up"><br><br>
  </form>
</div>
</body>
</html>