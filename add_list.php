<?php
session_start();
    include "db_connect.php";
    include "functions.php";
    $user_data = check_login($conn);
    $id = $user_data['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<title>Add Stock</title>
<head>    
    <header>
    <link rel="stylesheet" href="normalize.css">
    <link rel="stylesheet" href="skeleton.css">
    <div class="topnav" id="myTopnav">
        <a href="index.php" class="active">Dashboard</a>
        <div class="dropdown">
        <button class="dropbtn">Portfolio
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-content">
            <a href="portfolio_edit.php">Stock Portfolio</a>
            <a href="options.php">Options Portfolio</a>
        </div>
        </div>

        <div class="dropdown">
        <button class="dropbtn">Investing Tools
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-content">
            <a href="stock_news.php">News Search</a>
            <a href="screener.php">Stock Screener</a>
            <a href="watchlist.php">Watchlist</a>
        </div>
        </div>
        <a href="logout.php">Logout</a>
        <a href="javascript:void(0);" class="icon" onclick="myFunction()">&#9776;</a>
    </div>
    <script>
        /* Toggle between adding and removing the "responsive" class to topnav when the user clicks on the icon */
        function myFunction() {
        var x = document.getElementById("myTopnav");
        if (x.className === "topnav") {
            x.className += " responsive";
        } else {
            x.className = "topnav";
        }
        }
    </script>
    </header>
</head>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">  
</head>
<body>
    <h1>Add Stock</h1>
    <?php
        if(isset($_GET['ticker'])) {
            $ticker = $_GET['ticker'];
            $sql = "INSERT INTO watchlist (user_id, ticker) VALUES ('$id', '$ticker')";
            mysqli_query($conn, $sql);
            echo "$ticker was successfully added to your watchlist<br>";
            echo "<a a href='screener.php'>Click here to return to the stock screener</a>";
        } else {
            // code to execute if the variable is not set
            $ticker = "Ticker is not set";
            echo $ticker;
        }
    ?>
</body>
</html>