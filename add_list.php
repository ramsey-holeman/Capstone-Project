<?php
session_start();
    include "db_connect.php";
    include "functions.php";
    $user_data = check_login($conn);
    $id = $user_data['user_id'];
    $ticker = $_GET['ticker'];

    if(isset($_GET['ticker'])) {
        $sql = "INSERT INTO watchlist WHERE user_id=$id AND ticker=$ticker";
        mysqli_query($conn, $sql);
        header("location: screener.php");
    } else {
            // code to execute if the variable is not set
            $ticker = "Ticker is not set";
            echo $ticker;
        }
?>