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
  <title>Stock News</title>
  <link rel="stylesheet" href="style.css">
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>   
</head>
<body>
  <h1>Stock News</h1>

  <p style="text-align: center;">Enter your desired ticker below</p>
    <form action="stock_news.php" method="POST">
      <label for="text">Search:</label>
      <input type="text" name="ticker" id="ticker"><br>

      <label for="number">Amount of articles:</label>
      <input type="number" name="num_news" id="num_news"><br>

      <input type="submit" value="Search">
    </form>
  <?php
  $apiKey = '6efc26598c705a46c16082b0640c7c0f';
  $searchTerm = '' . $_POST['ticker'];
  $limit = 0 + $_POST['num_news'];
  
  // Initialize variables
  $count = 0;
  
  // Loop through the pages of results until the limit is reached or all results are fetched
  while ($count < $limit) {
    // Build the API URL for the current page of results
    $url = "https://financialmodelingprep.com/api/v3/stock_news?tickers=$searchTerm&page=0&apikey=$apiKey";
    
    // Fetch the results from the API
    $response = file_get_contents($url);
    
    // Parse the JSON response into an array
    $data = json_decode($response, true);
    
    // Loop through the news articles and print the title and summary
    foreach ($data as $article) {
      // Print the title and summary
      echo "<h2>{$article['title']}</h2>";
      echo "<p>{$article['text']}</p>";
      echo "<a href='article['URL']'>Click here for the full article</a>";
      
      // Increment the count of articles displayed
      $count++;
      
      // If we have reached the limit, break out of the loop
      if ($count >= $limit) {
        break;
      }
    }
   }
  ?>
  
</body>