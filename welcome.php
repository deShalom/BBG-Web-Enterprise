<?php
	session_start();
	
	if(!isset($_SESSION['login_user']))
	{           // if used attempts to access this site without being logged in, verified by session, they will be taken back to login.php with a error msgs!
		header("location: login.php?YouAreNotLoggedIn");
	}
	
	$level = intval($_SESSION['level_user']);
	if ($level < -4){
		header("location: banned.php");
	}
	
	include 'config.php';
	
	$userID = $_SESSION['userID'];
	$LastLogged = $_SESSION['LastLogIn'];
	
	$date = date('Y-m-d H:i:s'); //now you can save in DB
	$query = "SELECT LastLoggedIn, Username FROM Accounts WHERE UserID = $userID";
	$result = mysqli_query($conn, $query);
	if(mysqli_num_rows($result) == 0)
	{
		$messages = "Welcome New User";
	}
	else
	{
		while($row = mysqli_fetch_assoc($result)) {
            $messages = "Welcome " . $row['Username'] . ". Last Login was: " . $LastLogged;
        }
	}
?>


<!DOCTYPE html>


<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<title> GRE: Verified</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--This is the link to our CSS!-->
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	<link rel="stylesheet" href="https://daredicing.com/css.css%22%3E">
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
	.sB {
		margin-top: 50px;
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

<!-- Page Content -->
<div class="page w3-content" style="max-width:1500px">
	
	<div class="w3-white w3-border-bottom">
		<img src="Images/uog-logo.png" style="margin-bottom: 10px; margin-top: 10px;">
	</div>
	
	<!-- Banned user content -->
	<div class="w3-display-middle" style="background-color:#060360;">
		<p class="w3-margin-right w3-margin-left" style="color:#ffffff"><i class="fas fa-check w3-margin-right" style="color:#ffffff"></i><?php echo $messages ?> </p>
	</div>
	
	<button class="sB w3-display-middle w3-button" style="background-color:#060360; color:#ffffff"><a href="http://daredicing.com/index.php"><i class="fas fa-sign-out-alt"></i>Click Here</button></a>
	
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
           <a href="https://www.snapchat.com/add/uniofgreenwich" target="_blank"><i class="fab fa-snapchat-ghost w3-margin-right"></i></a>
           <a href="https://twitter.com/UniofGreenwich" target="_blank"><i class="fab fa-twitter w3-margin-right"></i></a>
           <a href="https://www.facebook.com/uniofgreenwich/" target="_blank"><i class="fab fa-facebook-f w3-margin-right"></i></a>
           <a href="https://www.instagram.com/uniofgreenwich/?hl=en" target="_blank"><i class="fab fa-instagram w3-margin-right"></i></a>
			</div>
</body>
</html>