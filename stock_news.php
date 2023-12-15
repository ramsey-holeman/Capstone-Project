<?php
session_start();
  include "db_connect.php";
  include "functions.php";
  $user_data = check_login($conn);
  $id = $user_data['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<title>Stock News</title>
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
  <title>Stock News</title>
  <link rel="stylesheet" href="style.css">
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>   
</head>
<body>
  <h1 style="text-align: center;">Stock News</h1>

  <p style="text-align: center;">Enter your desired ticker below</p>
    <form action="stock_news.php" method="POST">
      <label for="text">Search:</label>
      <input type="text" name="ticker" id="ticker"><br>

      <label for="number">Amount of articles:</label>
      <input type="number" name="num_news" id="num_news"><br>

      <input type="submit" value="Search">
    </form>
<?php
  if(array_key_exists("ticker", $_POST)) {
    // API key
    $api_key = "6efc26598c705a46c16082b0640c7c0f";
    // stock ticker to search for
    $ticker = $_POST['ticker'];
    // maximum number of articles to display
    $max_articles = $_POST['num_news'];

    // Set the counter variable to zero
    $count = 0;

    // Loop until the counter is greater than the max articles
    while ($count < $max_articles) {

        // API request
        $request_url = "https://financialmodelingprep.com/api/v3/stock_news?tickers=$ticker&apikey=$api_key";
        $response = file_get_contents($request_url);
        $json = json_decode($response, true);

        // Iterate over the news articles and display them
        foreach ($json as $article) {
            echo "<h3>" . $article["title"] . "</h3>";
            echo "<p>" . $article["text"] . "</p>";
            echo "<p><a href='{$article["url"]}' target='_blank'>Read more</a></p>";
            echo "<hr>";
            $count++;

            // Check if the counter is equal to the maximum number of articles
            if ($count == $max_articles) {
                break 2;
            }
        }
        // Wait for 1 second before making the next API request
        sleep(1);
    }
}else{
  // If ticker array is not set then make it null
  $ticker = null;}
?>
  
</body>