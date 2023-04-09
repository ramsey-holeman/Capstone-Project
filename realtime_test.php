<!DOCTYPE html>
<html>
<head>
	<title>Real-Time Stock Quotes</title>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script>
		$(document).ready(function() {
			var symbols = ['AAPL', 'MSFT', 'GOOGL']; // Array of stock symbols to track
			var updateInterval = 5000; // Update interval in milliseconds (5 seconds)
			var apiKey = '6efc26598c705a46c16082b0640c7c0f'; // Replace with your own API key

			// Function to fetch and display stock quotes
			function getStockQuotes() {
				var url = 'https://financialmodelingprep.com/api/v3/quote/' + symbols.join(',') + '?apikey=' + apiKey;

				$.getJSON(url, function(data) {
					$.each(data, function(index, stock) {
						$('#price-' + stock.symbol).text('$' + stock.price.toFixed(2)); // Display price for each symbol
					});
				});
			}

			// Initial call to fetch stock quotes
			getStockQuotes();

			// Set up interval to update stock quotes
			setInterval(function() {
				getStockQuotes();
			}, updateInterval);
		});
	</script>
</head>
<body>
	<h1>Real-Time Stock Quotes</h1>
	<table>
		<thead>
			<tr>
				<th>Symbol</th>
				<th>Price</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>AAPL</td>
				<td id="price-AAPL"></td>
			</tr>
			<tr>
				<td>MSFT</td>
				<td id="price-MSFT"></td>
			</tr>
			<tr>
				<td>GOOGL</td>
				<td id="price-GOOGL"></td>
			</tr>
		</tbody>
	</table>
</body>
</html>
