<?php
session_start();
    include "db_connect.php";
    include "functions.php";
    $user_data = check_login($conn);

    // Adds the user inputted stock information to the database
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // something was posted
        // Collect information from form
        $stock = $_POST['ticker'];
        $shares = $_POST['share_num'];
        $cost = $_POST['cost'];
        $date = $_POST['date'];
    
        if(!empty($stock) && !empty($shares) && !empty($cost) && !empty($date)){
            // save to database
            $id = $_SESSION['user_id'];
            $sql = "insert into stocks (user_id,ticker,share_num,cost,date) values('$id', '$ticker', '$share_num', '$cost', '$date')";
            mysqli_query($conn, $sql);
            echo "Position added successfully";
            header("Location: portfolio_edit.php");
            die();
    
        }else{
            echo "Please enter some valid information";
        }
        
      }


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
    <title>Add to Portfolio</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Add Stocks</h2>
    <p>Here you can add stocks that are in your portfolio</p>
    <form action="" method = "post">
        <label for="ticker">Stock Ticker:</label>
        <input style="text-transform: uppercase;" type="text" name="ticker" id="ticker" style="text-transform:uppercase"><br>
        
        <label for="share_num">Number of Shares:</label>
        <input type="text" id="share_num" name="share_num"><br>

        <label for="cost">Average cost of share:</label>
        <input type="number" name="cost" id="cost"><br>

        <label for="date">Date of Transaction:</label>
        <input type="date" name="date" id="date"><br>

        <input type="submit" value="Add"><br>
    </form>
</body>
</html>