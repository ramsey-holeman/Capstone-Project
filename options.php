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
    <title>Options Portfolio</title>
</head>
<body>
    <h2 style="text-align: center;">Options Positions</h2>
    <div>
    <p></p>

    <?php
    // Adds the user inputted stock information to the database
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // something was posted
        // Collect information from form
        $stock = $_POST['ticker'];
        $contract = $_POST['con_num'];
        $cost = $_POST['cost'];
        $date = $_POST['date'];
        $call_put = $_POST['call_put'];
        $exp = $_POST['exp_date'];

        //Makes the ticker uppercase
        $stock = strtoupper($stock);
     
        // If statement works only if a certain button is pressed
        if(isset($_POST['buy_stock'])) {
            if(!empty($stock) && !empty($contract) && !empty($cost) && !empty($date) && !empty($call_put)){
                $id = $_SESSION['user_id'];
                $check_stock = "SELECT * FROM options WHERE ticker='$stock' AND user_id='$id' LIMIT 1";
                $result = mysqli_query($conn, $check_stock);
                // If not found save to database
                if ($result->num_rows == 0){
                    $id = $_SESSION['user_id'];
                    $sql = "INSERT INTO options (user_id,ticker,contract_num,cost,call_put,date,exp) VALUES('$id', '$stock', '$contract', '$cost', '$call_put', '$date', '$exp')";
                    mysqli_query($conn, $sql);
                    echo "Position added successfully. You have bought $contract shares of $stock";
                    header("Location: options.php");
                    exit();
                }
                else{
                    $id = $_SESSION['user_id'];
                    $sql = "UPDATE options SET contract_num = contract_num + ? WHERE ticker = ? AND user_id = ?";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, 'isi', $contract, $stock, $id);
                    mysqli_stmt_execute($stmt);
                    
                    //Add and average cost function
                    echo "Position updated successfully. You have bought $contract shares of $stock";
                    header("Location: options.php");
                    exit();
                }
        
            }else{
                echo "Please enter some valid information";
            }
        }
        if(isset($_POST['sell_stock'])) {
           
            if(!empty($stock) && !empty($contract) && !empty($cost) && !empty($date)){
                $t_con = $contract * 100;
                $totalval = $cost * $contract; 
                $check_stock = "select * from options where ticker='$stock' limit 1";
                $result = mysqli_query($conn, $check_stock);
                // Checks if stock is in the database
                if ($result->num_rows == 1){
                    $id = $_SESSION['user_id'];
                    $sql = "UPDATE options SET contract_num = contract_num - ? WHERE ticker = ? AND user_id = ?";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, 'isi', $contract, $stock, $id);
                    mysqli_stmt_execute($stmt);
                    
                    $check_user = "select * from profit_loss where user_id='$id' limit 1";
                    $pl = mysqli_query($conn, $check_user);
                    // Checks if user has a row in the table, if not it will start a new row
                    if ($pl->num_rows == 0){
                      $in = "insert into profit_loss (user_id,options_pl) values('$id', '$totalval')";
                      mysqli_query($conn, $in);
                    }else{
                      // If the user has a row it will be updated accordingly
                      $in = "UPDATE profit_loss SET options_pl = options_pl + ? WHERE user_id = ?";
                      $instmt = mysqli_prepare($conn, $in);
                      mysqli_stmt_bind_param($instmt, 'ii', $totalval, $id);
                      mysqli_stmt_execute($instmt);
                    }
                    
                    // Your SQL query to delete the row
                    $sql = "DELETE FROM options WHERE contract_num <= 0";

                    if ($conn->query($sql) === TRUE) {
                    echo "Row(s) deleted successfully";
                    } else {
                    echo "Error deleting row(s): " . $conn->error;
                    }

                    $conn->close();
                    echo "Position updated successfully. You have sold $contract shares of $stock";
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
        <input type="submit" name="sell_stock" value="Sell"><br>
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
                  // Shows the options that are open in the account
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