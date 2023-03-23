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
    <!-- <link rel="stylesheet" href="style.css"> -->
    <link rel="stylesheet" href="normalize.css">
    <link rel="stylesheet" href="skeleton.css">
    <div id="wrap">
        <nav>
            <ul class="navbar">
                <a href="index.php">Dashboard</a>
                <a href="portfolio_edit.php">Edit Portfolio</a>
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
    <title>Portfolio Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>  
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
                //is3D:true,  
                pieHole: 0.4  
                };  
        var chart = new google.visualization.PieChart(document.getElementById('piechart'));  
        chart.draw(data, options);  
    }  
    </script>  
</head>
<body>
    <h1>Portfolio Dashboard</h1>
    <h4>Hello, <?php echo $user_data['first_name']; echo " "; echo $user_data['last_name']; ?>! Welcome back!</h4>
    
    <h6 style="text-align:center">Stocks In Your Portfolio</h6>
    <div id="piechart" class="chartClass"></div>
<?php
###################################################################################################################################
// if (!$conn) {
//   die("Connection failed: " . mysqli_connect_error());
// }

// $sql = "SELECT ticker FROM stocks WHERE user_id = $id";
// $result = mysqli_query($conn, $sql);

// if (mysqli_num_rows($result) > 0) {
//   // Step 2: For each stock symbol, make a request to the IEX Cloud API to retrieve its latest price
//   while ($row = mysqli_fetch_assoc($result)) {
//     $symbol = $row['ticker'];
//     $apiKey = 'pk_4d0ca80ec38a41848be36a8ae380a17b'; // Replace with your IEX Cloud API key
//     $apiUrl = "https://cloud.iexapis.com/stable/stock/{$symbol}/quote/latestPrice?token={$apiKey}";

//     $ch = curl_init();
//     curl_setopt($ch, CURLOPT_URL, $apiUrl);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     $response = curl_exec($ch);
//     curl_close($ch);

//     // Step 3: Print out the stock symbol and its latest price
//     if ($response) {
//       #echo "{$symbol}: $" . number_format((float)$response, 2, '.', '') . "\n";
//     } else {
//       echo "Failed to retrieve stock price for {$symbol}.\n";
//     }
//     echo "</tr>";
//     echo "</table>";
//   }
// } else {
//   echo "No stocks found in database.\n";
// }

// mysqli_close($conn);
######################################################################################################################################################
?>

<!-- JavaScript code -->
<script>
// const symbol = 'AAPL'; // Replace with the stock symbol you're interested in
// const apiUrl = 'get_price.php?symbol=' + symbol;

// function updatePrice() {
//   const xhr = new XMLHttpRequest();
//   xhr.onreadystatechange = function() {
//     if (this.readyState === 4 && this.status === 200) {
//       document.getElementById('price').textContent = this.responseText;
//     }
//   };
//   xhr.open('GET', apiUrl, true);
//   xhr.send();
// }

// // Update the price every 5 seconds
// setInterval(updatePrice, 5000);
</script>

<!-- PHP code: get_price.php -->
<?php
// $symbol = $_GET['symbol'];
// $apiKey = 'pk_4d0ca80ec38a41848be36a8ae380a17b'; // Replace with your IEX Cloud API key
// $apiUrl = "https://cloud.iexapis.com/stable/stock/$symbol/quote/latestPrice?token=$apiKey";
// echo file_get_contents($apiUrl);
################################################################################################################################
?>   



<table>
  <tr>
      <th>Symbol</th>
      <th>Price</th>
  </tr>
  <tbody>
<?php
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT ticker FROM stocks WHERE user_id = $id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  // Step 2: For each stock symbol, make a request to the IEX Cloud API to retrieve its latest price
  while ($row = mysqli_fetch_assoc($result)) {
    $symbol = $row['ticker'];
    $apiKey = 'pk_4d0ca80ec38a41848be36a8ae380a17b'; // Replace with your IEX Cloud API key
    $apiUrl = "https://cloud.iexapis.com/stable/stock/{$symbol}/quote/latestPrice?token={$apiKey}";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    // Step 3: Print out the stock symbol and its latest price
    if ($response) {
      #echo "{$symbol}: $" . number_format((float)$response, 2, '.', '') . "\n";
      echo "<tr>";
      echo "<td>". $symbol . "</td>";
      echo "<td>" . $response . "</td>";
      echo "</tr>";
      echo "</table>";

    } else {
      echo "Failed to retrieve stock price for {$symbol}.\n";
    }
    
  }
} else {
  echo "No stocks found in database.\n";
}
?>
  </tbody>
  </table> 
</body>
</html>