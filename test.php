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
                <a href="stock_news.php">News</a>
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
  <title>*TEST PAGE*</title>
  <link rel="stylesheet" href="style.css">
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>   
</head>
<body>
<?php
// Set the API key
$api_key = "6efc26598c705a46c16082b0640c7c0f";
// Set the stock ticker to search for
$ticker = "AAPL";
// Set the maximum number of articles to display
$max_articles = 5;

// Set the counter variable to zero
$count = 0;

// Loop until the counter is less than the maximum number of articles
while ($count < $max_articles) {

    // Make the API request
    $request_url = "https://financialmodelingprep.com/api/v3/stock_news?tickers=$ticker&apikey=$api_key";
    $response = file_get_contents($request_url);

    // Decode the JSON response
    $json = json_decode($response, true);

    // Iterate over the news articles and display them
    foreach ($json as $article) {
        echo "<h3>" . $article["title"] . "</h3>";
        echo "<p>" . $article["text"] . "</p>";
        echo "<p><a href=\"" . $article["url"] . "\">Read more</a></p>";
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
?>
</body>