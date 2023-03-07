<?php
session_start();
    include "db_connect.php";
    include "functions.php";
    $user_data = check_login($conn);

?>
<!DOCTYPE html>
<html lang="en">
<title>Dashboard</title>
<head>    
  <header>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <link rel="stylesheet" href="normalize.css">
    <link rel="stylesheet" href="skeleton.css">
    <div id="wrap">
        <ul class="navbar">
            <a href="index.php">Dashboard</a>
            <a href="portfolio_edit.php">Edit Portfolio</a>
            <a href="login_page.php">Login</a><br>
            <a href="logout.php">Logout</a>
        </ul>
      </div>    
  </header>
</head>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Portfolio Dashboard</h1>
    <h4>Hello, <?php echo $user_data['first_name']; echo " "; echo $user_data['last_name']; ?>! Welcome back!</h4>
    
</body>
</html>