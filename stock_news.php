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
  $ticker = null;
}
?>
  
</body>