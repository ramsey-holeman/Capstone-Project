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
    <title>Add to Portfolio</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <link rel="stylesheet" href="normalize.css">
    <link rel="stylesheet" href="skeleton.css">
</head>
<body>
    <h2>Add Stocks</h2>
    <div>
    <p>Here you can add stocks that are in your portfolio</p>

    <?php
    // Adds the user inputted stock information to the database
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // something was posted
        // Collect information from form
        $stock = $_POST['ticker'];
        $shares = $_POST['share_num'];
        $cost = $_POST['cost'];
        $date = $_POST['date'];

        //Makes the ticker uppercase
        $stock = strtoupper($stock);
     
        // If statement works only if a certain button is pressed
        if(isset($_POST['buy_stock'])) {
            if(!empty($stock) && !empty($shares) && !empty($cost) && !empty($date)){
                
                $check_stock = "select * from stocks where ticker='$stock' limit 1";
                $result = mysqli_query($conn, $check_stock);
                // If not found save to database
                if ($result->num_rows == 0){
                    $id = $_SESSION['user_id'];
                    $sql = "insert into stocks (user_id,ticker,share_num,cost,date) values('$id', '$stock', '$shares', '$cost', '$date')";
                    mysqli_query($conn, $sql);
                    echo "Position added successfully. You have bought $shares shares of $stock";
                    header("Location: portfolio_edit.php");
                    exit();
                }
                else{
                    $id = $_SESSION['user_id'];
                    $sql = "UPDATE stocks SET share_num = share_num + ?  AND (cost + ?) / 2 WHERE ticker = ? AND user_id = ?";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, 'idsi', $shares, $cost, $stock, $id);
                    mysqli_stmt_execute($stmt);
                    
                    // mysqli_query($conn, $sql);
                    echo "Position updated successfully. You have bought $shares shares of $stock";
                    header("Location: portfolio_edit.php");
                    exit();
                }
        
            }else{
                echo "Please enter some valid information";
            }
        }
        if(isset($_POST['sell_stock'])) {
            echo "This is Button2 that is selected";
            if(!empty($stock) && !empty($shares) && !empty($cost) && !empty($date)){
                // save to database
                $id = $_SESSION['user_id'];
                $sql = "insert into stocks (user_id,ticker,share_num,cost,date) values('$id', '$stock', '$shares', '$cost', '$date')";
                mysqli_query($conn, $sql);
                echo "Position added successfully";
                header("Location: portfolio_edit.php");
                exit();
        
            }else{
                echo "Please enter some valid information";
            }
        }
        
      }

    ?>

    <form action="#" method = "post" autocomplete="off">
        <label for="ticker">Stock Ticker:</label>
        <input style="text-transform: uppercase;" type="text" name="ticker" id="ticker" style="text-transform:uppercase"><br>
        
        <label for="share_num">Number of Shares:</label>
        <input type="text" id="share_num" name="share_num"><br>

        <label for="cost">Average cost per share:</label>
        <input type="number" name="cost" id="cost" step=any><br>

        <label for="date">Date of Transaction:</label>
        <input type="date" name="date" id="date"><br>

        <input type="submit" name="buy_stock" value="Buy"><br>
        <input type="submit" name="sell_stock" value="Sell"><br>
    </form>
    </div>
</body>
</html>