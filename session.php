
<?php

include_once 'config.php';

session_start();// Starting Session
// Storing Session
$user_check=$_SESSION['login_user'];
$pass_check=$_SESSION['password'];
$userID=$_SESSION['userID'];
// SQL Query To Fetch Complete Information Of User
$ses_sql=mysqli_query("SELECT userID, username, pass FROM accounts where userID='$userID' username='$user_check' AND pass='$pass_check'", $conn);
$row = mysqli_fetch_assoc($ses_sql);
$login_session =$row['username'];
if(!isset($login_session)){
    mysqli_close($conn); // Closing Connection
    header('Location: index.php'); // Redirecting To Home Page
}
?>
