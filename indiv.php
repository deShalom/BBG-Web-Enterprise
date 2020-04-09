<?php
    session_start();
    include "config.php";
    
	if(!isset($_SESSION['login_user']))
	{           // if used attempts to access this site without being logged in, verified by session, they will be taken back to login.php with a error msgs!
		header("location: login.php?YouAreNotLoggedIn");
	}

    $postID = $_GET["id"];

    mysqli_query($conn, "UPDATE Posts SET Views=Views+1 WHERE PostID=$postID");
   
    $postData = mysqli_query($conn, "SELECT Title, Body, PostID, UserID, Category1ID, Category2ID, Category3ID, Upvotes, Downvotes, Department, isAnonymous FROM Posts WHERE PostID=$postID");
    
    $post = mysqli_fetch_array($postData);
    $category1ID = $post['Category1ID'];
    $category2ID = $post['Category2ID'];
    $category3ID = $post['Category3ID'];
    $anon = $post['isAnonymous'];

 //   $categoryData = mysqli_query($conn, "SELECT CategoryName, CategoryID FROM Categories WHERE CategoryID IN (SELECT CategoryID FROM Categories WHERE CategoryID ='$category1ID' OR CategoryID ='$category2ID' OR CategoryID ='$category3ID')");
  
    $category1Name = mysqli_query($conn, "SELECT CategoryName FROM Categories WHERE CategoryID = $category1ID;");
    $category2Name = mysqli_query($conn, "SELECT CategoryName FROM Categories WHERE CategoryID = $category2ID;");
    $category3Name = mysqli_query($conn, "SELECT CategoryName FROM Categories WHERE CategoryID = $category3ID;");

    $commentsData = mysqli_query($conn, "SELECT UserID, Body FROM Comments WHERE PostID=$postID");
    $userID = $post['UserID'];
    $userData = mysqli_query($conn, "SELECT Username FROM Accounts WHERE UserID=$userID");
    $user = mysqli_fetch_array($userData);
    $LoggedInUserID=$_SESSION['userID'];
    $upvotes = mysqli_query($conn, "SELECT COUNT(DISTINCT userID) as Up FROM Votes WHERE PostID = $postID AND VoteType = 1");
    $downvotes = mysqli_query($conn, "SELECT COUNT(DISTINCT userID) AS Down FROM Votes WHERE PostID = $postID AND VoteType = 0")

?>

<!DOCTYPE html>


<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title> GRE: Comment page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--This is the link to our CSS!-->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>

<style>
    .page{
        align-content: center;
    }
    html{
        width:100%;
        height:100%;
    }
    body{
        width:100%;
        height:100%;
    }
    .navB {

    }
    .navR {

    }
    .footer {
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
        color: white;
        text-align: center;
    }
    .bI {
        width: 100%;
    }
    @media only screen and (max-width:800px) {
        /* For tablets: */
        .main {
            width: 80%;
            padding: 0;
        }
        .right {
            width: 100%;
        }
    }
    @media only screen and (max-width:500px) {
        /* For mobile phones: */
        .menu, .main, .right, .flex-container, .bI, .hT {
            width: 100%;
            flex-direction: column;

        }
    }
    .column {
        float: left;
        width: 33.33%;
    }

    /* Clear floats after the columns */
    .row:after {
        content: "";
        display: table;
        clear: both;
    }
</style>

<body>



<!-- Navigation Bar (Within Header) -->
<div class="w3-padding-8">
    <div class="w3-bar w3-dark-gray">
        <div class="w3-right w3-bar-item w3-button">Logout</div>
        <button class="w3-button w3-dark-gray w3-margin-top" name="logout" ><a href="logout.php">LOGOUT HERE</a></button>
    </div>
</div>

<!-- Page Content -->
<div class="page w3-content" style="max-width:1500px">

    <div class="w3-white w3-border-bottom">
        <button class="w3-button w3-white w3-xlarge" onclick="w3_open()">☰</button>
        <img src="Images/uog-logo.png" style="margin-bottom: 10px; margin-top: 10px;">
    </div>

    <!-- Sidebar -->
    <div class="w3-sidebar w3-bar-block w3-border-bottom" style="display:none" id="mySidebar">
        <button onclick="w3_close()" class="w3-bar-item w3-large">Close &times;</button>
        <a href="ideaSubmission.php" class="w3-bar-item w3-button">Idea Sub</a>
        <a href="#" class="w3-bar-item w3-button">Link 2</a>
        <a href="#" class="w3-bar-item w3-button">Link 3</a>
        <a href="registration.php" class="w3-bar-item w3-button">Link Reg</a>
    </div>

    <div class="w3-container">
        <!-- This  is the field for the idea's title -->
        <p class="w3-center"><u><?= $post["Title"]; ?></u></p>
        <!-- This  is the field for the idea's text -->
        <p class="w3-center w3-border">Idea's example text here!</p>
    </div>

    <fieldset>
        <p class="w3-center">
            <label for="fname">Ideas</label><br />

        </p>
        <div class="w3-panel">
            <div class="w3-row-padding w3-padding-16">
                <div class="flex-container">
                    <div class="column ">
                        <p>Title: <?= $post["Title"]; ?></p>

                        <p> Body: <?= $post["Body"]; ?></p>

                        <p>Department: <?= $post["Department"]; ?></p>

                        <!--- Show upvotes and downvotes--->
                        <p>Downvotes: <?php while($row = mysqli_fetch_assoc($downvotes)){
                            echo ($row['Down']);
                        } 
                        
                        ?>
                        </p>
                        <p>Upvotes: <?php  while($row = mysqli_fetch_assoc($upvotes)){
                            echo ($row['Up']);
                        } 
                        ?>
                        </p>

                        <!--- if not show username--->
                        <p> Posted by: <?= $anon == 1 ? "Anon" : $user['Username']; ?></p>
                        <p>
                            Categories: 
                        <?php
                        if (isset($category1ID)){
                        while ($row = mysqli_fetch_assoc($category1Name)){
                             echo ($row['CategoryName']." | ");
                            }}
                        if (isset($category2ID)){
                        while ($row = mysqli_fetch_assoc($category2Name)){
                             echo ($row['CategoryName']. " | ");
                            }}
                            if (isset($category3ID)){
                        while ($row = mysqli_fetch_assoc($category3Name)){
                             echo ($row['CategoryName']);
                        }}
                        ?>
                        </p>
                    </div>

               

               
                <form action="/thumbsup.php?id=<?= $postID ?>" id="thumbufrm"method="post">
                <button type="w3-button submit" name="thumbsUp" value="upvote">Thumbs Up</button>
                </form>
                <form action="/thumbsdown.php?id=<?= $postID ?>" id="thumbdfrm"method="post">
                <button type="w3-button submit" name="thumbsDown" value="downvote">Thumbs Down</button>
                </form>
                

                </div>
            </div>
            <form action="/comment.php" id="usrform" method="post">
                    <div>
                        <input type='hidden' name='UserID' value='Anonymous'>
                        <input type='hidden' name='PostID' value='postID'>
                        <textarea name="messages"></textarea><br>
                        <input type='checkbox' id='anoncheck' name='anoncheck' value='Anon'>
                        <label for="anoncheck"> Post Anonymously</label><br>
                        <button type="w3-button submit" name="submitpost">Comment</button>
                    </div>
                </form>
                <div>
                    <h3>Comments</h3>
                <p>
                <?php
                    while($comment = mysqli_fetch_assoc($commentsData)) {
                $commentuserID= $comment['UserID'];
                $getusername= mysqli_query($conn,"SELECT Username FROM Accounts WHERE UserID=$commentuserID");
                   $username = mysqli_fetch_assoc($getusername);
                    echo ("Posted by ".$username['Username']."<br>");
                    echo ($comment['Body']."<br><br>");
               
                    }
                ?></p>
                </div>
        </div>
    </fieldset>



    <script>
        function w3_open() {
            document.getElementById("mySidebar").style.display = "block";
        }

        function w3_close() {
            document.getElementById("mySidebar").style.display = "none";
        }
    </script>
</div>

<div class="footer w3-dark-gray">
    <p><span style='border-bottom:2px white solid;'>Other useful links!</p></span>
    <i class="fab fa-snapchat-ghost w3-margin-right"></i>
    <i class="fab fa-twitter w3-margin-right"></i>
    <i class="fab fa-facebook-f w3-margin-right"></i>
    <i class="fab fa-instagram w3-margin-right"></i>
</div>
</body>
</html>