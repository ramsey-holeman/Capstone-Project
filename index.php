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
    <link rel="stylesheet" href="style.css">
    <div id="wrap">
        <ul class="navbar">
            <a href="login_page.php">Login</a><br>
            <a href="logout.php">Logout</a>
            <a href="portfolio_edit.php">Edit Portfolio</a>
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
    
</body>
</html>