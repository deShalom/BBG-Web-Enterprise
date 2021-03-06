﻿<?php
    include "config.php";

    $message = "";
	
if(isset($_SESSION['login_user']))
{           // if used attempts to access this site without being logged in, verified by session, they will be taken back to login.php with a error msgs!
    header("location: index.php?YouAlreadyHaveAnAccount");
}

		$date_now = date("Y-m-d");
	$datequery = ("SELECT EnteredDate, DisableOrClose FROM Dates WHERE DisableOrClose = '1'");
	$resultdate = mysqli_query($conn, $datequery);
	$rowsdate = mysqli_num_rows($resultdate);
    if ($rowsdate > 0) 
    {            
		while($rowsdate = mysqli_fetch_assoc($resultdate)) {
					
			$gotDate = $rowsdate['EnteredDate'];
		}
		
		if ($date_now > $gotDate){
				header("location: siteclosed.php");
		} else{
			
		}
	}
	else 
    {
	}


	if (isset($_POST['registrationBtn']))
    {
		$username = mysqli_real_escape_string($conn, $_POST['username']);
		$email = mysqli_real_escape_string($conn ,$_POST['email']);
		$password = mysqli_real_escape_string($conn ,$_POST['password']);
		$Confirmpassword = mysqli_real_escape_string($conn ,$_POST['confirm-password']);
		$Department = mysqli_real_escape_string($conn ,$_POST['ResDept']);

        if($username == "" || $email == "" || $password !== $Confirmpassword || $Department == "")
        {
            $messages = "Check Fields" ;
        }  else
        {
               $query = ("SELECT * FROM Accounts WHERE Email= '$email'");
               if($query->num_rows > 0)
               {
                     $message = "Email already in database";
               }
               else
               {
                    $token = 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890!$/()';
			        $token = str_shuffle($token);
			        $token = Substr($token, 0, 15);

			        $hashPassword = password_hash($password, PASSWORD_DEFAULT);

                    $query = "INSERT INTO Accounts (Username, Password, Email, Department, Level, isConfirmed, token)
					VALUES('$username', '$hashPassword', '$email', '$Department', 0, 0, '$token')";

                    if($query) {
                         ini_set("SMTP", 'n3plcpnl0054.prod.ams3.secureserver.net');
                         ini_set("sendmail_from", "noreply@daredicing.com");

                           $to = $email;
                           $subject = "Email Verification";
                           $message = "Hello, $username. Thank for signing up on daredicing.com, you will recieve an email shortly.
                            <a href=\"http://daredicing.com/confirmemail.php?email=$email&token=$token\">Click Here</a><p> Best of luck from BigBoiGames Ltd";
                           $header = "From: noreply@daredicing.com";
                           $headers .= "MIME-Version: 1.0" . "\r\n";
                           $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                           mail($to, $subject, $message, $headers);

                           header("location: evar.php");
                        mysqli_query($conn, $query);
                    }
                    }
            }
    };

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




?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>GRE: Registration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--This is the link to our CSS!-->
    <link rel="stylesheet" href="https://daredicing.com/css.css">
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

    <!-- Page Content -->
    <div class="page w3-content" style="max-width:1500px">

        <!-- Gre header -->
        <div class="w3-white w3-border-bottom w3-center">
            <img src="Images/uog-logo.png" style="margin-bottom: 10px; margin-top: 10px;">
        </div>

        <!-- This divider will hold the log-in box -->
        <form action="registration.php" method="post" class="w3-display-middle w3-margin-right w3-container w3-card-4 w3-greenwich" onsubmit="return validateForm();">
            <h2 class="w3-center">Create an account</h2>

			 <?php
              if($message != "")
              {
                  echo $message;
              }
        ?>
              <script>
                function validateForm()
                {
                    const passcode = document.getElementById('password').value;
                    const conpass = document.getElementById('confirm-password').value;
                    let valid = true;

                    if (conpass !== passcode)
                    {
                    alert("Passwords dont match");
                    valid = false;
                    }

                if (valid === true)
                    {
                    return true;
                    }
                    return false;

                }
            </script>

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
			</p>
			 <!-- Password input field -->
            <p class="w3-center">
                <label>Confirm Password</label>
                <i class="fas fa-lock"></i>
                <input class="w3-input w3-border w3-center" type="password" name="confirm-password" placeholder="Password" id="confirm-password" required>
			 </p>
			<!-- Email input field -->
			<p class="w3-center">
				  <label>Email</label>
				  <i class="fas fa-lock"></i>
				  <input class="w3-input w3-border w3-center" type="text" name="email" placeholder="EMAIL" id="email" required>
			 </p>
			<!-- Department-->
			<fieldset>
				<p class="w3-center">
                <select id="Department" name="ResDept" class="w3-dropdown-click" required>
                <?php
              $departmentQuery = "SELECT Department, COUNT(*) FROM Accounts GROUP BY Department HAVING COUNT(*) > 0 ORDER BY Department ASC";
                    $resultDepartment = mysqli_query($conn, $departmentQuery);
                    while($rowDepartment=mysqli_fetch_array($resultDepartment))
                    {
                         echo '<option>' . $rowDepartment['Department'] . '</option>';
                    }
                ?> 
                </select></p>
			 </fieldset>

				<button class="w3-center w3-button greenwich w3-hover-dark-gray w3-margin-top" name="registrationBtn" value="Registration">Submit</button>
        </form>
		</div>
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
