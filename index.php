<?php
session_start();
    include "db_connect.php";
    include "functions.php";
    $user_data = check_login($conn);
    
    $query = "SELECT ticker, share_num FROM stocks";
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
        <ul class="navbar">
            <a href="index.php">Dashboard</a>
            <a href="portfolio_edit.php">Edit Portfolio</a>
            <a href="login_page.php">Login</a><br>
            <a href="logout.php">Logout</a>
        </ul>
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
    <script type="text/javascript" style="margin-left: auto; margin-right: auto">  
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
                title: 'Stocks in your portfolio',  
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
    
    <div id="piechart" style="width: 900px; height: 500px;"></div>  
</body>
</html>