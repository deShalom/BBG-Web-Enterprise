<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>GRE: Registration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--This is the link to our CSS!-->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>

<style>

    .page {
        align-content: center;
    }

    html {
        width: 100%;
        height: 100%;
    }

    body {
        width: 100%;
        height: 100%;
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

<?php
if(isset($_POST['Submit']))
{
require 'config.php';

$USERNAME = $_POST['username'];
$PASSWORD = $_POST['password'];
$CONFIRMPASSWORD = $_POST['confirm-password'];
$EMAIL = $_POST['email'];

if(empty($USERNAME) || empty($PASSWORD) || empty($CONFIRMPASSWORD) || empty($EMAIL))
{
	header("Location: ../Registration.html?error=emptyfields&username=".$USERNAME.);
	exit();
}
else if(!filter_var($email, FILTER_VALIDATE_EMAIL) &&("/^[a-zA-Z0-9]*$/", $USERNAME))
{
	header("Location: ../Registration.html?error=invaildinformation");
	exit();
}

else if(!preg_match("/^[a-zA-Z0-9]*$/", $USERNAME)
{
	header("Location: ../Registration.html?error=invaildemail=".$EMAIL);
	exit();
}
else if($PASSWORD !== $CONFIRMPASSWORD)
{
	header("Location: ../Registration.html?error=passwordcheckusername=".$USERNAME. "&email=" .$EMAIL);
	exit();
}
else 
{
	$sql = "SELECT * FROM Accounts WHERE Username=?";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql))
	{
		header("Location: ../Registration.html?error=databaseerrorr");
		exit();
	}
	else 
	{
		mysqli_stmt_bind_param($stmt, "s", $USERNAME );
		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt)
		
		$resultChecker = mysqli_stmt_num_rows($stmt);
		if ($resultChecker > 0)
		{
			header("Location: ../Registration.html?error=usernametaken");
			exit()
		}
		else {
			
			/* ADDED THE FIELDS FROM THE SQL TABLE */
			$sql = "INSERT INTO Accounts (Username, Password,Email) VALUES (?, ?, ?)";
			$stmt = mysqli_stmt_init($conn);
		if (!mysqli_stmt_prepare($stmt, $sql))
			{
			header("Location: ../Registration.html?error=databaseerrorr");
			exit();
			
			}
		else 
			{
			
		$hashPassword = password_hash($PASSWORD, PASSWORD_DEFAULT);	
		mysqli_stmt_bind_param($stmt, "sss", $USERNAME, $PASSWORD, $EMAIL);
		mysqli_stmt_execute($stmt);
		header("Location: ../Registration.html?RegistrationComplete");
		exit();
			}
		}
	}

mysqli_stmt_close($stmt);
mysqi_close($conn);

}
?>

    <!-- Page Content -->
    <div class="page w3-content" style="max-width:1500px">

        <!-- Gre header -->
        <div class="w3-white w3-border-bottom w3-center">
            <img src="Images/uog-logo.png" style="margin-bottom: 10px; margin-top: 10px;">
        </div>

        <!-- This divider will hold the log-in box -->
        <form action="authenticate.php" method="post" class="w3-display-right w3-margin-right w3-container w3-card-4 w3-dark-grey">
            <h2 class="w3-center">Create an account</h2>

				<?php
				if(isset($_GET['error']))
				{
					if($_GET['error'] == "emptyfields")
					{
						echo '<p class="signuperror"> Fill in the information! </p>';
					} 
					else if($_GET['Error'] == "invaildinformation")
					{
						echo '<p class="signuperror"> Check Information </p>';
					} 
					else if($_GET['Error'] == "invaildemail")
					{
						echo '<p class="signuperror"> Check Email </p>';
					}
					else if($_GET['Error'] == "passwordcheckusername")
					{
						echo '<p class="signuperror"> passwords do not match </p>';
					}
					else if($_GET['Error'] == "usernametaken")
					{
						echo '<p class="signuperror"> Username Taken </p>';
					}
					else if($_GET['signup'] == "RegistrationComplete")
					{
						echo '<p class="signupsuccessful"> Registration Complete </p>';
					}
				}  
?>

            <!-- Username input field -->
            <p class="w3-center">
                <label>Please enter a Username below</label>
                <i class="fas fa-user"></i>
                <input class="w3-input w3-border w3-center" type="text" name="username" placeholder="Username" id="username" required>
            </p>

            <!-- Password input field -->
            <p class="w3-center">
                <label>Please enter a Password below</label>
                <i class="fas fa-lock"></i>
                <input class="w3-input w3-border w3-center" type="password" name="password" placeholder="Password" id="password" required>
				
			 <!-- Password input field -->
            <p class="w3-center">
                <label>Confirm Password</label>
                <i class="fas fa-lock"></i>
                <input class="w3-input w3-border w3-center" type="password" name="password" placeholder="Password" id="password" required>
				
			<!-- Department  -->
				<p class="w3-center">
                <label>Confirm Password</label>
                <i class="fas fa-lock"></i>
                <input class="w3-input w3-border w3-center" type="password" name="password" placeholder="Password" id="password" required>
				
				<button class="w3-button w3-dark-gray w3-margin-top">Submit</button>
        </form>
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