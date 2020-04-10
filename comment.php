<?php
session_start();

if(!isset($_SESSION['login_user']))
{           // if used attempts to access this site without being logged in, verified by session, they will be taken back to login.php with a error msgs!
    header("location: login.php?YouAreNotLoggedIn");
}

// opens a connection to the DB via the config file
include 'config.php';
$postID = $_GET["id"];
$LoggedInUserID=$_SESSION['userID'];


$comment = $_POST['messages'];
echo ($comment);
$anoncheck = $_POST['anoncheck'];
if (isset($anoncheck)){
    $anon=1;
} else {
    $anon=0;
}
//$anoncheck == 1 ? $anon = 1 : $anon = 0;
echo($anon);
$addcomment = "INSERT INTO Comments (Body, PostID, UserID, isAnonymous) VALUES ('$comment', $postID, $LoggedInUserID, $anon);";
if(mysqli_query($conn,$addcomment)){
    echo "comment posted!";
} else{
    echo "ERROR: Could not execute $sql. " . mysqli_error($conn);
}
$getuserID = "SELECT UserID FROM Posts WHERE PostID = $postID";
$gotuserID = mysqli_query($conn, $getuserID);
$gottenuserID = mysqli_fetch_assoc($gotuserID);

$getemail = mysqli_query($conn, "SELECT Email FROM Accounts WHERE UserID = $gottenuserID[UserID]");
$email =  mysqli_fetch_assoc($getemail);

    ini_set("SMTP", 'n3plcpnl0054.prod.ams3.secureserver.net');
    ini_set("sendmail_from", "noreply@daredicing.com");

    $to = $email['Email'];
    $subject = "New comment on your idea";
    $message = "A new comment has been posted on your idea. 
                            <a href=\"http://daredicing.com/indiv.php?id=$postID\">Click Here</a><p> to view it.";
    $headers = "From: noreply@daredicing.com";
    $headers .= "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    mail($to, $subject, $message, $headers);



header("Location: indiv.php?id=$postID");



?>