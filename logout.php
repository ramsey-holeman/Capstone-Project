<?php
session_start();

// If session is active then unset the session variable
if(isset($_SESSION['user_id'])){
    unset($_SESSION['user_id']);
}

header("Location: login_page.php");
die();

?>