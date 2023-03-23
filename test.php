<form method="post">
    <label for="keywords">Enter keywords to search for:</label>
    <input type="text" name="keywords" id="keywords">
    <input type="submit" value="Search">
  </form>

  <?php
  // Check if the form has been submitted
  if (isset($_POST['keywords'])) {
    // Get the user input from the form
    $keywords = $_POST['keywords'];
  
    // Set the API endpoint URL with the user input
    $url = "https://www.alphavantage.co/query?function=SYMBOL_SEARCH&keywords=" . urlencode($keywords) . "&apikey=99AZK8RLIWQZZQA6";
  
    // Send a GET request to the API endpoint and retrieve the JSON response
    $response = file_get_contents($url);
  
    // Decode the JSON response into a PHP associative array
    $search_results = json_decode($response, true)["bestMatches"];
  
    // Output the search results
      echo "<table>";
      foreach ($search_results as $result) {
      echo "<tr>";
      echo "<td>" . $result['1. symbol'] . "</td>";
      echo "<td>" . $result['2. name'] . "</td>";
      echo "<td><button onclick=\"selectTicker('" . $result['1. symbol'] . "')\">Select</button></td>" . "<br>";
      echo "</tr>";
    }
    echo "</table>";
  }


//   // Check if the form has been submitted
// if (isset($_POST['ticker'])) {
//   // Get the user input from the form and sanitize it
//   $ticker = $_POST['ticker'];

//   // Validate the ticker symbol
//   if (preg_match('/^[A-Z]{1,5}$/', $ticker)) {
//         // Prepare the SQL statement
//     $stmt = $conn->prepare("INSERT INTO portfolio (ticker) VALUES (?)");

//     // Bind the ticker symbol parameter and execute the statement
//     $stmt->bind_param("s", $ticker);
//     $stmt->execute();

//     // Close the statement and the connection
//     $stmt->close();
//     $conn->close();

//     // Output a success message
//     echo "Ticker symbol added to portfolio!";
//   } else {
//     // Output an error message if the ticker symbol is invalid
//     echo "Invalid ticker symbol. Please try again.";
//   }
// }
?>

<?php
// Set the API endpoint and parameters
$endpoint = "https://www.alphavantage.co/query";
$function = "GLOBAL_QUOTE"; // The API function to retrieve the latest stock price
$symbol = "AAPL"; // The stock symbol to retrieve the price for
$apikey = "99AZK8RLIWQZZQA6"; // Your Alpha Vantage API key

// Make the API request
$url = "$endpoint?function=$function&symbol=$symbol&apikey=$apikey";
$response = file_get_contents($url);

// Parse the JSON response and extract the latest stock price
$result = json_decode($response, true);
$latestPrice = $result["Global Quote"]["05. price"];

// Do something with the latest stock price, such as saving it to a database or displaying it on your website
echo "The latest price for $symbol is $latestPrice";
?>
