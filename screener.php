<?php error_reporting(0); ?> 
<?php
session_start();
  include "db_connect.php";
  include "functions.php";
  $user_data = check_login($conn);
  $id = $user_data['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<title>Stock Screener</title>
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
  <title>Stock Screener</title>
  <link rel="stylesheet" href="style.css">  
</head>
<body>
  <h1 style="text-align: center;">Stock Screener</h1>
  <p style="text-align: center;">Enter parameters below to screen for stocks</p>
  <!-- Form to screen for stocks -->
  <form action="" method="POST">
    <label for="max_cap">Market cap greater than:</label>
    <input type="number" name="max_cap" id="max_cap">

    <label for="min_cap">Market cap less than:</label>
    <input type="number" name="min_cap" id="min_cap">

    <label for="max_price">Share price greater than:</label>
    <input type="number" name="max_price" id="max_price"><br>

    <label for="min_price">Share price less than:</label>
    <input type="number" name="min_price" id="min_price">

    <label for="max_vol">Stock volume greater than:</label>
    <input type="number" name="max_vol" id="max_vol">

    <label for="min_vol">Stock volume less than:</label>
    <input type="number" name="min_vol" id="min_vol"><br>

    <label for="sector">Company Sector:</label>
    <select name = "sector">
        <option disabled selected value> -- select an option -- </option>
        <?php 
        $select = "SELECT * FROM sector";
        $result = mysqli_query($conn, $select);
        while ($row = mysqli_fetch_array($result)) {
          echo '<option>'.$row['sector'].'</option>';
        }
        ?>
    </select>

    <label for="industry">Company Industry:</label>
    <select name = "industry">
        <option disabled selected value> -- select an option -- </option>
        <?php 
        $select = "SELECT * FROM industry";
        $result = mysqli_query($conn, $select);
        while ($row = mysqli_fetch_array($result)) {
          echo '<option>'.$row['industry'].'</option>';
        }
        ?>
    </select>

    <label for="exchange">Exchange:</label>
    <select name = "exchange">
        <option disabled selected value> -- select an option -- </option>
        <?php 
        $select = "SELECT * FROM exchange";
        $result = mysqli_query($conn, $select);
        while ($row = mysqli_fetch_array($result)) {
          echo '<option>'.$row['exchange'].'</option>';
        }
        ?>
    </select><br>

    <label for="limit">Max number of results:</label>
    <input type="number" name="limit" id="limit" required>

    <input type="submit" value="Search">

  </form>
  <?php
    // Stores to variables
    if($_SERVER["REQUEST_METHOD"] == "POST"){
      $max_cap = $_POST["max_cap"];
      $min_cap = $_POST["min_cap"];
      $max_price = $_POST["max_price"];
      $min_price = $_POST["min_price"];
      $max_vol = $_POST["max_vol"];
      $min_vol = $_POST["min_vol"];
      $sector = $_POST["sector"];
      $industry = $_POST["industry"];
      $exchange = $_POST["exchange"];
      $limit = $_POST["limit"];

      $apiKey = '6efc26598c705a46c16082b0640c7c0f';
      $url = "https://financialmodelingprep.com/api/v3/stock-screener?marketCapMoreThan=$max_cap&marketCapLessThan=&$min_cap&priceMoreThan=$max_price&priceLessThan=$min_price&volumeMoreThan=$max_vol&volumeLessThan=$min_vol&sector=$sector&industry=$industry&exchange=$exchange&limit=$limit&apikey=$apiKey";
      
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $response = curl_exec($ch);
      curl_close($ch);

      $data = json_decode($response, true);
  ?>
  <table>
    <thead>
      <tr>
        <th>Symbol</th>
        <th>Company Name</th>
        <th>Market Cap</th>
        <th>Price</th>
        <th>Add to Database</th>
      </tr>
    </thead>
    <tbody>      
      <?php
      // Loop through the results of the form submission and put them in a HTML table
      foreach ($data as $stock) {
        $marketCap = number_format($stock['marketCap']);
        $price = round(2, $stock['price']);
        $ticker = $stock['symbol'];
      ?>
      <tr>
        <td><?php echo $stock['symbol']; ?></td>
        <td><?php echo $stock['companyName']; ?></td>
        <td><?php echo $marketCap; ?></td>
        <td><?php echo $stock['price']; ?></td>
        <td><?php echo "<a href='add_list.php?ticker=$ticker'>Add $ticker to watchlist</a>"?></td>
      </tr>
      <?php
        }
      }
      ?>
    </tbody>
  </table>
</body>