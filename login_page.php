<?php
  session_start();
  include "db_connect.php";
  include "functions.php";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
      $email = $_POST['email'];
      $pword = $_POST['pword'];

      if(!empty($email)){
          // read from database

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
          echo "Wrong username or password!";
      }else{
          echo "Please enter some valid information!";
      }
      
    }
  }

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Login Page</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <link rel="stylesheet" href="style.css"> -->
  <link rel="stylesheet" href="normalize.css">
  <link rel="stylesheet" href="skeleton.css">
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
      <p style="text-align: center">Don't have an account? <a href="sign_up.php">Click here to sign up!</a></p>
    </div>
</body>
</html>