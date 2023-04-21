<?php
session_start();
  include "db_connect.php";
  include "functions.php";
  $user_data = check_login($conn);
  $id = $user_data['user_id'];

// Query the database to get portfolio data
$sql = "SELECT ticker, share_num, cost FROM stocks WHERE user_id = $id";
$result = $conn->query($sql);

// Calculate the current value of each stock using the Financial Modeling Prep API
$api_key = "6efc26598c705a46c16082b0640c7c0f";
$data = array();
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $ticker = $row["ticker"];
    $shares = $row["share_num"];
    $cost_basis = $row["cost"];
    $url = "https://financialmodelingprep.com/api/v3/stock/real-time-price/$ticker?apikey=$api_key";

    $response = file_get_contents($url);
    $json = json_decode($response, true);
    $current_price = $json["price"];
    $current_value = $shares * $current_price;
    $profit_loss = $current_value - $cost_basis;
    array_push($data, array("ticker" => $ticker, "value" => $current_value, "profit_loss" => $profit_loss));
  }
}

// Close the database connection
$conn->close();

// Convert data to JSON and send it to the client
echo json_encode($data);
?>
