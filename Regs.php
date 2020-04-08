<?php
	session_start();
	include "config.php";
    include PHPMailer\PHPMailer\PHPMailer;
    include PHPMailer\PHPMailer\SMTP;
    include PHPMailer\PHPMailer\Exception;

    // Load Composer's autoloader
    require 'phpmailer/vendor/autoload.php';

	if (isset($_POST['registrationBtn'])) {
		$username = mysqli_real_escape_string($conn, $_POST['username']);
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$password = mysqli_real_escape_string($conn, $_POST['password']);
		$Confirmpassword = mysqli_real_escape_string($conn, $_POST['confirm-password']);
		$Department = mysqli_real_escape_string($conn, $_POST['ResDept']);


			$Token = 'qwertyuiopasdfghjklzxcvbnm1234567890!$/()';
			$Token = str_shuffle($Token);
			$Token = Substr($Token, 0, 15);
			

			$hashPassword = password_hash($password, PASSWORD_DEFAULT);	

			$query = "INSERT INTO Accounts (Username, Password, Email, Department, Level, isConfirmed, token) 
					  VALUES('$username', '$hashPassword', '$email', '$Department', 0, 0, '$Token')";
			mysqli_query($conn, $query);

            $mail = new PHPMailer(true);

            ///SMPT SETTINGS
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host = 'n3plcpnl0054.prod.ams3.secureserver.net';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'noreply@daredicing.com';
            $mail->Password   = 'fyC7~4}v@dCG';
            $mail->SMTPSecure = 'PHPMailer::ENCRYPTION_STARTTLS';
            $mail->Port       = 587 ;

            $mail->SetFrom('Noreply@DareDicing.com', 'Noreply');
            $mail->addAddress($email, $username);
            $mail->isHTML(true);
            $mail->Subject = 'Sign Up Link';
            $mail->Body = "Hello, $username. Thank for signing up on daredicing.com, you will recieve an email shortly.
            <a href='http://daredicing.com/confirmemail.php?email=$email&token=$Token'> </a>

            Best of luck from BigBoiGames Ltd";

            if($mail->send())
            {
                alert("You have signed up on daredicing.com. You will recieve an email now.");
                header("Location: /login.php");
                exit();
            }
            else
            {
                alert("Something went wrong: {$mail->ErrorInfo}");
            }
?>