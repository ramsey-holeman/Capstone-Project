<?php
  session_start();
  include "db_connect.php";
  include "functions.php";
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Login Page</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">   
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
<body>
    <h2 style="text-align: center">Login</h2>
    <div>
      <form style="text-align: center" action="" method = "post" autocomplete="off">
          <label for="email">Email:</label>
          <input type="email" name="email" id="email"><br>
          
          <label for="pword">Password:</label>
          <input type="password" id="pword" name="pword"><br>

          <input type="submit" value="Login">
      </form>
      <h6 style="text-align: center">
      <?php
      if($_SERVER["REQUEST_METHOD"] == "POST"){
        $email = $_POST['email'];
        $pword = $_POST['pword'];
        if(!empty($email)){
          // read from database
          // Checks if the email address exists in the database
          $sql = "select * from users where email='$email' limit 1";
          $result = mysqli_query($conn, $sql);  
          if($result){
            if ($result && mysqli_num_rows($result) > 0){
              $user_data = mysqli_fetch_assoc($result);
              if($user_data['pword'] === $pword)
              {  
                $id = $_SESSION['user_id'] = $user_data['user_id'];
                header("Location: index.php");
                die;
            }
          }
          // Echos under the submit button
            echo "Wrong username or password!";
          }else{
              echo "Please enter some valid information!";
            }  
          }
        }
      ?>
      </h6>
      <p style="text-align: center">Don't have an account? <a href="sign_up.php">Click here to sign up!</a></p>
    </div>
</body>
</html>