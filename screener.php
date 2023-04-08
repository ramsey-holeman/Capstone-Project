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
    <div id="wrap">
        <nav>
            <ul class="navbar">
                <a href="index.php">Dashboard</a>
                <a href="portfolio_edit.php">Edit Portfolio</a>
                <a href="options.php">Stock Options</a>
                <a href="screener.php">Stock Screener</a>
                <a href="stock_news.php">News</a>
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
  <title>Stock Screener</title>
  <link rel="stylesheet" href="style.css">  
</head>
<body>
  <h1>Stock Screener</h1>
  <p>Enter parameters below to screen for stocks</p>
  <form action="" method="POST">
    <label for="max_cap">Market cap greater than</label>
    <input type="number" name="max_cap" id="max_cap">

    <label for="min_cap">Market cap less than</label>
    <input type="number" name="min_cap" id="min_cap">

    <label for="max_price">Share price greater than</label>
    <input type="number" name="max_price" id="max_price">

    <label for="min_price">Share price less than</label>
    <input type="number" name="min_price" id="min_price">

    <label for="max_vol">Stock volume greater than</label>
    <input type="number" name="max_vol" id="max_vol">

    <label for="min_vol">Stock volume less than</label>
    <input type="number" name="min_vol" id="min_vol">

    <label for="sector">Company Sector</label>
    <select name = "sector">
        <option disabled selected value> -- select an option -- </option>
        <?php 
        $select = "SELECT * FROM sector";
        $result = mysqli_query($conn, $select);
        while ($row = mysqli_fetch_array($result)) {
          echo '<option>'.$row['sector'].'</option>';
        }
        ?>
    </select><br><br>

    <label for="industry">Company Industry</label>
    <select name = "industry">
        <option disabled selected value> -- select an option -- </option>
        <?php 
        $select = "SELECT * FROM industry";
        $result = mysqli_query($conn, $select);
        while ($row = mysqli_fetch_array($result)) {
          echo '<option>'.$row['industry'].'</option>';
        }
        ?>
    </select><br><br>

    <label for="exchange">Exchange</label>
    <select name = "exchange">
        <option disabled selected value> -- select an option -- </option>
        <?php 
        $select = "SELECT * FROM exchange";
        $result = mysqli_query($conn, $select);
        while ($row = mysqli_fetch_array($result)) {
          echo '<option>'.$row['exchange'].'</option>';
        }
        ?>
    </select><br><br>

    <input type="submit" value="Search">

  </form>
  <?php
      $apiKey = '6efc26598c705a46c16082b0640c7c0f';
      $url = "https://financialmodelingprep.com/api/v3/stock-screener?marketCapMoreThan=1000000000&betaMoreThan=1&dividendYieldMoreThan=2&volumeMoreThan=1000000&sector=Technology&exchange=NASDAQ&apikey=$apiKey";
      
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $response = curl_exec($ch);
      curl_close($ch);

      $data = json_decode($response, true);

      // do something with the data here
      foreach ($data as $stock) {
          echo $stock['symbol'] . ' - ' . $stock['companyName'] . ' - ' . $stock['marketCap'] . '<br>';
      }
  ?>
</body>