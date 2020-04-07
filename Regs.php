<?php
	session_start();
	include "config.php";

	if (isset($_POST['registrationBtn'])) {
		$username = mysqli_real_escape_string($conn, $_POST['username']);
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$password = mysqli_real_escape_string($conn, $_POST['password']);
		$Confirmpassword = mysqli_real_escape_string($conn, $_POST['confirm-password']);
		$Department = mysqli_real_escape_string($conn, $_POST['ResDept']);
		
		if (empty($username)) { array_push($errors, "Username is required"); }
		if (empty($email)) { array_push($errors, "Email is required"); }
		if (empty($password)) { array_push($errors, "Password is required"); }

		if ($password != $Confirmpassword) {
			array_push($errors, "The two passwords do not match");
		}

		if (count($errors) == 0) {
			$Token = 'qwertyuiopasdfghjklzxcvbnm1234567890!$/()';
			$Token = str_shuffle($Token);
			$Token = Substr($Token, 0, 15);
			

			$hashPassword = password_hash($password, PASSWORD_DEFAULT);	

			$query = "INSERT INTO Accounts (Username, Password, Email, Department, Level, isConfirmed, token) 
					  VALUES('$username', '$hashPassword', '$email', '$Department', 0, 0, '$Token')";
			mysqli_query($conn, $query);
			
			
			include_once "PHPMailer/PHPMailer.php";
			
			$mail = new PHPMailer();
			$mail->SetFrom('Noreply@DareDicing.com');
			$mail->addAddress($email, $username);
			$mail->isHTML(TRUE);
			$mail->Subject = 'Sign Up Link';
			$mail->Body = "Hello, $username. Thank for signing up on daredicing.com, you will recieve an email shortly.
			<a href='HTTP://http://daredicing.com/confirmemail.php?email=$email&token$Token'> </a>
			";
			
			if($mail->send())
			{
				$errors = "You have signed up on daredicing.com. You will recieve an email now.";
			}
			else
			{
				$errors = "Something went wrong please try again.";
			}
			
			header("Location: /login.php");
			exit();
		}
	}
	
	

?>