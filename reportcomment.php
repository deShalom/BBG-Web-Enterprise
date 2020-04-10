<?php

session_start();

if (!isset($_SESSION['login_user'])) {           // if used attempts to access this site without being logged in, verified by session, they will be taken back to login.php with a error msgs!
    header("location: login.php?YouAreNotLoggedIn");
}

// opens a connection to the DB via the config file
include 'config.php';
$postID = $_GET["id"];
$LoggedInUserID = $_SESSION['userID'];
$commenttoreport = $_GET["commentid"];
echo($commenttoreport);
echo($postID);
$postuserID=mysqli_query($conn,"SELECT UserID FROM Posts WHERE PostID = $postID");
$postuserIDD=mysqli_fetch_assoc($postuserID);
$checkifreported = "SELECT ReportingUserID FROM Reports WHERE PostID = $postID;";
$resultcheckreported = mysqli_query($conn, $checkifreported);
$reportedrows = mysqli_num_rows($resultcheckreported);
if ($reportedrows == 0) {
$reportcomment = "INSERT INTO Reports (PostID, ReportingUserID, ReportedUserID) VALUES ($postID, $LoggedInUserID, $postuserIDD[UserID])";
if (mysqli_query($conn, $reportcomment)) {
    echo "comment reported!";
} else {
    echo "ERROR: Could not execute $sql. " . mysqli_error($conn);
}
}
header("Location: indiv.php?id=$postID&ReportSubmitted");
