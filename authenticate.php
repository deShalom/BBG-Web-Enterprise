<?php

session_start(); // Starting Session
$error=''; // Variable To Store Error Message
include_once 'config.php'; // db connection string
if (isset($_POST['loginbtn'])) 
{
    if (empty($_POST['username']) || empty($_POST['password'])) 
    {
        $error = "Username or Password is invalid";
    }
    else
    {
        // Define $username, $password
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        // SQL query to fetch information of registerd users and finds user match.
        $authquery = ("SELECT UserID, Username, Password FROM Accounts WHERE Username='$username' AND Password='$password'");
        $result = mysqli_query($conn, $authquery);
        $rows = mysqli_num_rows($result);
            if ($rows == 1) 
            {
                $_SESSION['login_user'] = $username; // Initializing Session
                $_SESSION['userID'] = $userID;
                header("location: index.php"); // Redirecting To Other Page
            } 
            else 
            {
                $error = "Username or Password is invalid";
                echo $error;
            }
            mysqli_close($conn); // Closing Connection
    }
}

?>





