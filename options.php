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
    <title>Options Portfolio</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <link rel="stylesheet" href="normalize.css">
    <link rel="stylesheet" href="skeleton.css">
</head>
<body>
    <h2>Options Positions</h2>
    <div>
    <p></p>

    <?php
    // Adds the user inputted stock information to the database
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // something was posted
        // Collect information from form
        $stock = $_POST['ticker'];
        $shares = $_POST['con_num'];
        $cost = $_POST['cost'];
        $date = $_POST['date'];
        $call_put = $_POST['call_put'];

        //Makes the ticker uppercase
        $stock = strtoupper($stock);
     
        // If statement works only if a certain button is pressed
        if(isset($_POST['buy_stock'])) {
            if(!empty($stock) && !empty($shares) && !empty($cost) && !empty($date) && !empty($call_put)){
                $id = $_SESSION['user_id'];
                $check_stock = "SELECT * FROM options WHERE ticker='$stock' AND user_id='$id' LIMIT 1";
                $result = mysqli_query($conn, $check_stock);
                // If not found save to database
                if ($result->num_rows == 0){
                    $id = $_SESSION['user_id'];
                    $sql = "INSERT INTO options (user_id,ticker,contract_num,cost,call_put,date) VALUES('$id', '$stock', '$shares', '$cost', '$call_put', '$date')";
                    mysqli_query($conn, $sql);
                    echo "Position added successfully. You have bought $shares shares of $stock";
                    header("Location: options.php");
                    exit();
                }
                else{
                    $id = $_SESSION['user_id'];
                    $sql = "UPDATE options SET contract_num = contract_num + ? WHERE ticker = ? AND user_id = ?";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, 'isi', $shares, $stock, $id);
                    mysqli_stmt_execute($stmt);
                    
                    //Add and average cost function
                    echo "Position updated successfully. You have bought $shares shares of $stock";
                    header("Location: options.php");
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
                    $sql = "UPDATE stocks SET con_num = con_num - ? WHERE ticker = ? AND user_id = ?";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, 'isi', $shares, $stock, $id);
                    mysqli_stmt_execute($stmt);
                    
                    // Check if number of shares is equal to zero
                    // $zero_stock = "select * from stocks where ticker='$stock' limit 1";
                    // $result = mysqli_query($conn, $zero_stock);
                    // if ($){

                    // }
                    
                    echo "Position updated successfully. You have sold $shares shares of $stock";
                    header("Location: options.php");
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
        
        <label for="con_num">Number of Contracts:</label>
        <input type="text" id="con_num" name="con_num"><br>

        <label for="cost">Average Contract Price:</label>
        <input type="number" name="cost" id="cost" step=any><br>

        <label for="call_put">Call or Put:</label><br>
        <input type="radio" id="call" name="call_put" value="Call">
        <label for="call">Call</label><br>
        <input type="radio" id="put" name="call_put" value="Put">
        <label for="put">Put</label><br>

        <label for="date">Date of Transaction:</label>
        <input type="date" name="date" id="date"><br>

        <label for="exp_date">Expiration Date:</label>
        <input type="date" name="exp_date" id="exp_date"><br>

        <input type="submit" name="buy_stock" value="Buy"><br>
        <!-- <input type="submit" name="sell_stock" value="Sell"><br> -->
    </form>
    </div>
    <div>
        <p>Stock currently in your portfolio</p>
        <table style="margin: auto">
            <thead>
                <tr>
                    <th>Stock Ticker</th>
                    <th>Number of Contract</th>
                    <th>Average Cost</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $id = $_SESSION['user_id'];
                    $results = mysqli_query($conn, "SELECT * FROM options WHERE user_id = $id");
                    while($row = mysqli_fetch_array($results)) {
                    ?>
                        <tr>
                            <td><?php echo $row['ticker']?></td>
                            <td><?php echo $row['contract_num']?></td>
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
</call>