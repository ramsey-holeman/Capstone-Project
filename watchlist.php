<?php
session_start();
    include "db_connect.php";
    include "functions.php";
    $user_data = check_login($conn);
    $id = $user_data['user_id'];
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
  <title>Watchlist</title>
</head>
<body>
    <h1>Watch List</h1>
    <p style="text-align: center;">Enter the stock you want to add to your watch list:</p>
    <form action="watchlist.php" method="post">
        <input type="text" name="list" id="list">
        <input type="submit" name="save" value="Save">
    </form>
    <?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $ticker = $_POST['list'];

        if(isset($_POST['save'])){
            if(!empty($ticker)){
                $sql = "INSERT INTO watchlist (user_id,ticker) VALUES ('$id','$ticker')";
                mysqli_query($conn, $sql);
                header("location: watchlist.php");
                echo "<p style='text-align: center;'>$ticker has been added to your watchlist successfully.</p>";
                exit();
            }
            else {
                echo "<p style='text-align: center;'>Error: Please add a ticker in the text box</p>";
            }
        }
        else {
            echo "<p style='text-align: center;'>Error adding $ticker to watchlist</p>";
        }
    }
    ?>
    <div>
        <p></p>
        <table style="margin: auto">
            <thead>
                <tr>
                    <td>Stock Ticker</td>
                    <td>Company Name</td>
                    <td>Current Price</td>
                    <td>Delete</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    $id = $_SESSION['user_id'];
                    $results = mysqli_query($conn, "SELECT * FROM watchlist WHERE user_id = $id");
                    while($row = mysqli_fetch_array($results)) {
                        // API key
                        $api_key = "6efc26598c705a46c16082b0640c7c0f";
                        $ticker = $row['ticker'];

                        // API endpoint
                        $url = "https://financialmodelingprep.com/api/v3/quote/{$ticker}?apikey={$api_key}";

                        // Send request to the API
                        $response = file_get_contents($url);

                        // Decode JSON response into an array
                        $data = json_decode($response, true);
                    ?>
                        <tr>
                            <td><?php echo $data[0]['symbol']?></td>
                            <td><?php echo $data[0]['name']?></td>
                            <td><?php echo round($data[0]['price'], 2)?></td>
                            <?php echo "<td><a href='delete.php?ticker=$ticker'>Delete $ticker from watchlist</a></td>"?>
                        </tr>
                    <?php
                    }
                    mysqli_close($conn);
                    ?>
            </tbody>
        </table>
    </div>
</body>