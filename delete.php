<?php
session_start();
    include "db_connect.php";
    include "functions.php";
    $user_data = check_login($conn);
    $id = $user_data['user_id'];
    $ticker = $_GET['ticker'];

    if(isset($_GET['ticker'])) {
        $stmt = $conn->prepare("DELETE FROM watchlist WHERE user_id=? AND ticker=?");
        $stmt->bind_param("is", $id, $ticker);
        $stmt->execute();
        header("location: watchlist.php");
        $stmt->close();
        $conn->close();
    } else {
            // code to execute if the variable is not set
            $ticker = "Ticker is not set";
            echo $ticker;
        }
        // Close the statement and connection  

?>