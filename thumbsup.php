<?php

session_start();

if(!isset($_SESSION['login_user']))
{           // if used attempts to access this site without being logged in, verified by session, they will be taken back to login.php with a error msgs!
    header("location: login.php?YouAreNotLoggedIn");
}
?>

<?php
// opens a connection to the DB via the config file
include 'config.php';
$postID = $_GET["id"];
$LoggedInUserID=$_SESSION['userID'];
if($conn === false){
                        die("ERROR: Could not connect. " . mysqli_connect_error());
                    }
                    $checkifvoted = "SELECT UserID FROM Votes WHERE PostID = $postID;";
                    $resultcheckvoted = mysqli_query($conn, $checkifvoted);
                    $votedrows = mysqli_num_rows($resultcheckvoted);
                    if ($votedrows == 0)
                    {
                    $upvInsert = "INSERT INTO Votes (PostID, UserID, VoteType) VALUES ($postID, $LoggedInUserID, 1);";
                    }else{
                        $upvInsert = "UPDATE Votes SET VoteType = 1 WHERE (PostID=$postID AND UserID=$LoggedInUserID);";
                    }
                    if(mysqli_query($conn,$upvInsert)){
                        echo "vote recorded!";
                    } else{
                        echo "ERROR: Could not execute $sql. " . mysqli_error($conn);
                    }
                    header("Location: indiv.php?id=$postID");


?>