<!DOCTYPE html>
<html>
<head>
    <title>Portfolio Pie Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <canvas id="piechart"></canvas>
    <script>
        // Send an AJAX request to the server to retrieve data from the MySQL database.
        var xmlhttp = new XMLHttpRequest();
        var url = "get_portfolio_data.php";
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Parse the JSON response from the server into an array.
                var data = JSON.parse(this.responseText);

                // Create the data array.
                var dataArray = [];
                var backgroundColorArray = ["#4CAF50", "#2196F3", "#FFC107", "#9C27B0", "#FF5722"];
                for (var i = 0; i < data.length; i++) {
                    dataArray.push(data[i].value);
                }

                // Set chart options.
                var options = {
                    title: {
                        display: true,
                        text: 'Portfolio'
                    },
                    legend: {
                        labels: {
                            fontColor: "white",
                            fontSize: 14
                        }
                    }
                    responsive: true,
                    maintainAspectRatio: false
                };

                // Instantiate and draw the pie chart.
                var pieChart = new Chart(document.getElementById('piechart'), {
                    type: 'pie',
                    data: {
                        labels: data.map(function(item) {
                            return item.ticker;
                        }),
                        datasets: [{
                            data: dataArray,
                            backgroundColor: backgroundColorArray
                        }]
                    },
                    options: options
                });
            }
        };
        xmlhttp.open("GET", url, true);
        xmlhttp.send();
    </script>
</body>
</html>
