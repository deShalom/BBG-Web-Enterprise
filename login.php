<?php
include('authenticate.php'); // Includes Login Script

	
	$pageName = basename($_SERVER['PHP_SELF']);
	$queryupdateViews = ("SELECT PageName, Views FROM Pages WHERE PageName = '$pageName'");
	$resultupdateViews = mysqli_query($conn, $queryupdateViews);
	$rowsupdateViews = mysqli_num_rows($resultupdateViews);
    
	if ($rowsupdateViews == 1)
	{
		while ($rowupdateViews = mysqli_fetch_array($resultupdateViews))
		{
			$addonreview = $rowupdateViews['Views'] + 1;
			$queryViewAdd = "UPDATE Pages SET Views = '$addonreview' WHERE PageName = '$pageName'";
			$resultToInsertView = mysqli_query($conn, $queryViewAdd);
			


		}
	}else{
		$queryEnterPage = ("Insert into Pages (PageName, Views) VALUES ('$pageName','1')");
		$resultEnterPage = mysqli_query($conn, $queryEnterPage);
	}
	
	if(isset($_SESSION['login_user']))
{           // if they are logged in no access to login page
    header("location: welcome.php");
}
	
 
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>GRE: Login</title>
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
</style>

<body>
<!-- Page Content -->
<div class="page w3-content" style="max-width:1500px">

<!-- Gre header -->
<div class="w3-white w3-border-bottom w3-center">
            <img src="Images/uog-logo.png" style="margin-bottom: 10px; margin-top: 10px;">
        </div>

    <!-- This divider will hold the log-in box -->
    <form method="post" action="" class="w3-display-middle w3-margin-right w3-container w3-card-4 w3-dark-grey">
        <h2 class="w3-center">Login</h2>

        <!-- Username input field -->
        <p class="w3-center" >
            <label>Username</label>
            <i class="fas fa-user"></i>
            <input class="w3-input w3-border w3-center" type="text" name="username" placeholder="Username" id="name" required>
        </p>
        <!-- Password input field -->
        <p class="w3-center">
            <label>Password</label>
            <i class="fas fa-lock"></i>
            <input class="w3-input w3-border w3-center" type="password" name="password" placeholder="Password" id="password" required>
            <button type="submit" class="w3-button w3-dark-gray w3-margin-top" name="loginbtn">Login</button>
            <br />
            <br />
            <br />
        <div>
            <a href="registration.php" button class="w3-button w3-dark-gray w3-display-bottommiddle w3-margin-bottom" >Create an account!</a>
        </div>

    </form>
    <br />
</div>


<div class="footer w3-dark-gray">
    <p><span style='border-bottom:2px white solid;'>Other useful links!</p></span>
    <i class="fab fa-snapchat-ghost w3-margin-right"></i>
    <i class="fab fa-twitter w3-margin-right"></i>
    <i class="fab fa-facebook-f w3-margin-right"></i>
    <i class="fab fa-instagram w3-margin-right"></i>
</div>
</body>

