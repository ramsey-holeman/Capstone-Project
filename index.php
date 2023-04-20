<?php
session_start();
    include "db_connect.php";
    include "functions.php";
    $user_data = check_login($conn);
    $id = $user_data['user_id'];
    $query = "SELECT ticker, share_num FROM stocks WHERE user_id = $id";
    $result = mysqli_query($conn, $query);
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
  <title>Portfolio Dashboard</title>
  <link rel="stylesheet" href="style.css">
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>   
</head>
<?php
  echo "<marquee class='watchlistMarquee' direction='left' scrollamount='8' behavior='scroll'>";
    $wSQL = "SELECT ticker FROM watchlist WHERE user_id = $id";
    $watchlist = mysqli_query($conn, $wSQL);
    echo "Stocks in your watchlist: ";
    while($row = mysqli_fetch_array($watchlist)){
      if(!$row){
        echo "Watchlist is empty, Please go to the watchlist page to enter stocks you want to watch!";
      }else{
      // API key
      $api_key = "6efc26598c705a46c16082b0640c7c0f";
      $ticker = $row['ticker'];

      // API endpoint
      $url = "https://financialmodelingprep.com/api/v3/quote/{$ticker}?apikey={$api_key}";

      // Send request to the API
      $response = file_get_contents($url);

      // Decode JSON response into an array
      $data = json_decode($response, true);

      // Echo out the response
      echo $data[0]['symbol'] . ": " . round($data[0]['price'], 2) . ", " . "\n";
      }
    }
  echo "</marquee>";
  ?>
<body>
    <h1>Portfolio Dashboard</h1>
    <h4>Hello, <?php echo $user_data['first_name']; echo " "; echo $user_data['last_name']; ?>! Welcome back!</h4>    
    <script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});  
    google.charts.setOnLoadCallback(drawChart);  
    function drawChart()  
    {  
        var data = google.visualization.arrayToDataTable([  
                    ['ticker', 'share_num'],  
                    <?php  
                    while($row = mysqli_fetch_array($result))  
                    {  
                        echo "['".$row["ticker"]."', ".$row["share_num"]."],";  
                    }  
                    ?>  
                ]);  
        var options = {  
                title: '',  
                pieHole: 0.4  
                };  
        var chart = new google.visualization.PieChart(document.getElementById('piechart'));  
        chart.draw(data, options);  

        function resizeChart () {
        chart.draw(data, options);
        }

      window.onload = resizeChart();
      window.onresize = resizeChart;
    }
    </script> 
    
    <h6 style="text-align:center">Stocks In Your Portfolio by Share Number</h6>
    <div class="chart-container">
      <div id="piechart" class="chartClass"></div>
    </div>
<table>
  <tr>
      <th>Symbol</th>
      <th>Price</th>
      <th>Current Value</th>
      <th>Profit/Lost</th>
  </tr>
  <tbody>
<?php
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT ticker, share_num, cost FROM stocks WHERE user_id = $id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  // For each stock symbol, make a request to the IEX Cloud API to retrieve its latest price
  while ($row = mysqli_fetch_assoc($result)) {
    $symbol = $row['ticker'];
    $shares = $row['share_num'];
    $cost = $row['cost'];

    // API key
    $api_key = "6efc26598c705a46c16082b0640c7c0f";
    // API endpoint
    $url = "https://financialmodelingprep.com/api/v3/quote/{$symbol}?apikey={$api_key}";

    // Send request to the API
    $response = file_get_contents($url);

    // Decode JSON response into an array
    $data = json_decode($response, true);

    // Shares * current stock price
    $current_total = round($data[0]['price'], 2) * (int)$shares;
    $total_round = round($current_total, 2);

    // Shares * avg cost per share
    $total_cost = (float)$cost * (int)$shares;
    $cost_round = round($total_cost, 2);
    
    // Current P&L
    $current_pl = $total_round - $cost_round;

    // Print out the stock symbol and its latest price
    if (round($data[0]['price'], 2) == true) {
    ?>
      <tr>
          <td><?php echo $symbol?></td>
          <td><?php echo round($data[0]['price'], 2)?></td>
          <td><?php echo $total_round?></td>
          <?php
            if($current_pl > 0)
            {
                echo "<td style='background-color:green;'>" . $current_pl . "</td>";
            }
            else
            {
              echo "<td style='background-color:red;'>" . "(" . $current_pl . ")" . "</td>";
            }
        ?>
      </tr>
    <?php
    } 
      else {
      echo "Failed to retrieve stock price for {$symbol}.\n";
    }
    
  }
} else {
  echo "No stocks found in database.\n";
}
mysqli_close($conn);
?>
  </tbody>
  </table> 
</body>
</html>