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
        <nav>
            <ul class="navbar">
                <a href="index.php">Dashboard</a>
                <a href="portfolio_edit.php">Edit Portfolio</a>
                <a href="options.php">Stock Options</a>
                <a href="stock_news.php">News</a>
                <a href="login_page.php">Login</a><br>
                <a href="logout.php">Logout</a>
            </ul>
        </nav>
    </div>     
  </header>
</head>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Portfolio</title>
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
                $id = $_SESSION['user_id'];
                $check_stock = "select * from stocks where ticker='$stock' and user_id='$id' limit 1";
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
                    $sql = "UPDATE stocks SET share_num = share_num + ? WHERE ticker = ? AND user_id = ?";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, 'isi', $shares, $stock, $id);
                    mysqli_stmt_execute($stmt);
                    
                    //Add and average cost function
                    echo "Position updated successfully. You have bought $shares shares of $stock";
                    header("Location: portfolio_edit.php");
                    exit();
                }
        
            }else{
                echo "Please enter some valid information";
            }
        }
        if(isset($_POST['sell_stock'])) {
            if(!empty($stock) && !empty($shares) && !empty($cost) && !empty($date)){

                $check_stock = "select * from stocks where ticker='$stock' limit 1";
                $result = mysqli_query($conn, $check_stock);
                // Checks if stock is in the database
                if ($result->num_rows == 1){
                    $id = $_SESSION['user_id'];
                    $sql = "UPDATE stocks SET share_num = share_num - ? WHERE ticker = ? AND user_id = ?";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, 'isi', $shares, $stock, $id);
                    mysqli_stmt_execute($stmt);
                    
                    // SQL query to delete the row
                    $sql = "DELETE FROM stocks WHERE share_num <= 0";

                    if ($conn->query($sql) === TRUE) {
                    echo "Row(s) deleted successfully";
                    } else {
                    echo "Error deleting row(s): " . $conn->error;
                    }
                    $conn->close();
                    
                    echo "Position updated successfully. You have sold $shares shares of $stock";
                    header("Location: portfolio_edit.php");
                    exit();
                }
                else{
                    echo "$stock is not in your portfolio";
                }
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
    <div>
        <p>Stock currently in your portfolio</p>
        <table style="margin: auto">
            <thead>
                <tr>
                    <td>Stock Ticker</td>
                    <td>Number of Shares</td>
                    <td>Average Cost</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    $id = $_SESSION['user_id'];
                    $results = mysqli_query($conn, "SELECT * FROM stocks WHERE user_id = $id");
                    while($row = mysqli_fetch_array($results)) {
                    ?>
                        <tr>
                            <td><?php echo $row['ticker']?></td>
                            <td><?php echo $row['share_num']?></td>
                            <td><?php echo $row['cost']?></td>
                        </tr>

                    <?php
                    }
                    mysqli_close($conn);
                    ?>
            </tbody>
        </table>
    </div>
</body>
</html>