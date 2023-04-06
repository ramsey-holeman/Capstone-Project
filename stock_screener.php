<?php
  include "db_connect.php";
  include "functions.php";
  $user_data = check_login($conn);
  $id = $user_data['user_id'];

  set_time_limit(0);

  $url_info = "https://financialmodelingprep.com/api/v3/stock-screener?marketCapMoreThan=1000000000&betaMoreThan=1&volumeMoreThan=10000&sector=Technology&exchange=NASDAQ&dividendMoreThan=0&limit=100&apikey=6efc26598c705a46c16082b0640c7c0f";

  $channel = curl_init();

  curl_setopt($channel, CURLOPT_AUTOREFERER, TRUE);
  curl_setopt($channel, CURLOPT_HEADER, 0);
  curl_setopt($channel, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($channel, CURLOPT_URL, $url_info);
  curl_setopt($channel, CURLOPT_FOLLOWLOCATION, TRUE);
  curl_setopt($channel, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
  curl_setopt($channel, CURLOPT_TIMEOUT, 0);
  curl_setopt($channel, CURLOPT_CONNECTTIMEOUT, 0);
  curl_setopt($channel, CURLOPT_SSL_VERIFYHOST, FALSE);
  curl_setopt($channel, CURLOPT_SSL_VERIFYPEER, FALSE);

  $output = curl_exec($channel);

  if (curl_error($channel)) {
      return 'error:' . curl_error($channel);
  } else {
  $outputJSON = json_decode($output);
    var_dump($outputJSON);
  }
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
  <title>Portfolio Dashboard</title>
  <link rel="stylesheet" href="style.css">
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>   
</head>
<body>
  
</body>