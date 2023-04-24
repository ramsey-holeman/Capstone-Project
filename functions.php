<?php
// checks if the user is logged in
function check_login($conn) {
    // check if session is logged in
    if(isset($_SESSION['user_id'])){
        $id = $_SESSION['user_id'];
        $query = "SELECT * FROM users WHERE user_id = $id limit 1";

        $result = mysqli_query($conn, $query);
        if ($result && mysqli_num_rows($result) > 0){
            $user_data = mysqli_fetch_assoc($result);
            return $user_data;
        }
    }
    // redirect to login page if not logged in
    header("Location: login_page.php");
    die;

}

// Random number generator function for generating IDs 
function random_num($length)
{
    $text = "";
    if($length < 5)
    {
        $length = 5;
    }

    $len = rand(4,$length);

    for ($i=0; $i < $len; $i++) { 
        $text .= rand(0,9);
    }
    return $text;
}
?>