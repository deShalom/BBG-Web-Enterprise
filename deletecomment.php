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
$commenttodelete = $_GET["commentid"];
echo ($commenttodelete);
echo($postID);
$deletecomment = "DELETE FROM Comments WHERE CommentID=$commenttodelete AND UserID=$LoggedInUserID;";
if(mysqli_query($conn,$deletecomment)){
    echo "comment deleted!";
} else{
    echo "ERROR: Could not execute $sql. " . mysqli_error($conn);
}
header("Location: indiv.php?id=$postID");
?>