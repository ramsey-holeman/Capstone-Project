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
  <title>Portfolio Dashboard</title>
  <link rel="stylesheet" href="style.css">
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>   
</head>
<?php
  echo "<marquee class='watchlistMarquee' direction='left' scrollamount='8' behavior='scroll'>";
    $wSQL = "SELECT ticker FROM watchlist WHERE user_id = $id";
    $watchlist = mysqli_query($conn, $wSQL);
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
      echo $data[0]['symbol'] . ": " . $data[0]['price'] . "\n";
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
                // is3D:true,  
                pieHole: 0.4  
                };  
        var chart = new google.visualization.PieChart(document.getElementById('piechart'));  
        chart.draw(data, options);  
    }  
    </script> 
    
    <h6 style="text-align:center">Stocks In Your Portfolio</h6>
    <div id="piechart" class="chartClass"></div>
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
    $apiKey = 'pk_4d0ca80ec38a41848be36a8ae380a17b'; // Replace with your IEX Cloud API key
    $apiUrl = "https://cloud.iexapis.com/stable/stock/{$symbol}/quote/latestPrice?token={$apiKey}";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $price = curl_exec($ch);
    curl_close($ch);

    // Shares * current stock price
    $current_total = (float)$price * (int)$shares;
    $total_round = round($current_total, 2);

    // Shares * avg cost per share
    $total_cost = (float)$cost * (int)$shares;
    $cost_round = round($total_cost, 2);
    
    // Current P&L
    $current_pl = $total_round - $cost_round;

    // Print out the stock symbol and its latest price
    if ($price == true) {
    ?>
      <tr>
          <td><?php echo $symbol?></td>
          <td><?php echo $price?></td>
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